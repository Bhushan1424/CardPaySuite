<?php 
include '../includes/header.php'; 

// --- LOGIC SECTION: Handle Parsing before HTML renders ---
$parsedData = [];
$error = "";

if (isset($_POST['tlv']) && $_POST['tlv'] != '') {
    try {
        $hexInput = $_POST['tlv'];
        
        // 1. Clean input: uppercase and remove non-hex characters
        $hex = strtoupper(preg_replace('/[^0-9A-F]/', '', $hexInput));
        
        $i = 0;
        $tempResults = [];

        while ($i < strlen($hex)) {
            // Parse Tag
            $tag = substr($hex, $i, 2);
            $i += 2;

            // Handle multi-byte tags (if the first byte's bits 5-1 are 1)
            if ((hexdec($tag) & 0x1F) == 0x1F) {
                while (true) {
                    $next = substr($hex, $i, 2);
                    if ($next === false) break;
                    $tag .= $next;
                    $i += 2;
                    if (!(hexdec($next) & 0x80)) break;
                }
            }

            // Parse Length
            if ($i >= strlen($hex)) break;
            $lenByte = substr($hex, $i, 2);
            $i += 2;

            if (hexdec($lenByte) > 127) {
                $bytes = hexdec($lenByte) - 128;
                $lengthHex = substr($hex, $i, $bytes * 2);
                $i += $bytes * 2;
                $length = (int) hexdec($lengthHex);
            } else {
                $length = (int) hexdec($lenByte);
            }

            // Parse Value
            $value = substr($hex, $i, $length * 2);
            $i += $length * 2;

            $tempResults[] = [
                'tag' => $tag,
                'length' => $length,
                'value' => $value
            ];
        }
        $parsedData = $tempResults;

    } catch (Throwable $e) {
        $error = "An error occurred while parsing the TLV structure.";
    }
}

// Load Tag Dictionary
$tagMap = [];
if (file_exists('../data/emv-tags.json')) {
    $dictionary = json_decode(file_get_contents('../data/emv-tags.json'), true);
    if ($dictionary) {
        foreach ($dictionary as $group) {
            foreach ($group as $tag => $desc) {
                $tagMap[strtoupper($tag)] = $desc;
            }
        }
    }
}
?>


<div class="page-wrapper">
    <section class="tools-page-section">
        <div class="container">
            
            <!-- TOOL HEADER -->
            <header class="tools-header" style="text-align: center; margin-bottom: 40px;">
                <h1 class="text-gradient">EMV TLV Parser</h1>
                <p class="tools-subtitle">Analyze Tag-Length-Value (TLV) structures used in EMV chip cards. Decode binary data into human-readable tags.</p>
            </header>

            <div class="tool-main-container" style="max-width: 1000px; margin: 0 auto;">
                
                <!-- INPUT PANEL -->
                <div class="glass-panel tool-input-card">
                    <div class="tool-card-header">
                        <i class="fa-solid fa-database"></i>
                        <span>Enter Hex Stream</span>
                    </div>
                    
                    <form method="POST" class="parser-form">
                        <textarea name="tlv" placeholder="Paste raw hex TLV data here (e.g. 9F0206000000000100...)" rows="6"><?php echo isset($_POST['tlv']) ? htmlspecialchars($_POST['tlv']) : ''; ?></textarea>
                        <div style="text-align: right; margin-top: 15px;">
                            <button type="submit" class="btn-primary">
                                <span>Parse TLV Structure</span>
                                <i class="fa-solid fa-gears"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- ERROR MESSAGE -->
                <?php if ($error): ?>
                    <div class="error-banner" style="display: flex; margin-top: 20px;">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <span><?php echo $error; ?></span>
                    </div>
                <?php endif; ?>

                <!-- RESULT PANEL -->
                <?php if (!empty($parsedData)): ?>
                    <div class="glass-panel result-card" style="margin-top: 30px; animation: slideUp 0.4s ease-out;">
                        <div class="result-card-header">
                            <h3 style="margin:0;">Parsed EMV Elements</h3>
                            <span class="status-badge approved"><?php echo count($parsedData); ?> Tags Found</span>
                        </div>

                        <div class="fields-table-wrapper">
                            <table class="fields-table">
                                <thead>
                                    <tr>
                                        <th>Tag</th>
                                        <th>Len (Bytes)</th>
                                        <th>Value (Hex)</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($parsedData as $row): ?>
                                        <tr>
                                            <td class="field-id"><?php echo $row['tag']; ?></td>
                                            <td style="color: var(--text-muted);"><?php echo $row['length']; ?></td>
                                            <td style="font-family: 'Courier New', monospace; color: #4ade80;"><?php echo $row['value']; ?></td>
                                            <td><?php echo $tagMap[strtoupper($row['tag'])] ?? 'Unknown Tag'; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </section>
</div>


<?php include '../includes/footer.php'; ?>
