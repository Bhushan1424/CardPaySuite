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

<!-- Link Custom CSS -->
<link rel="stylesheet" href="/assets/css/simulator.css">

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

<style>
    /* --- Page Layout --- */
    .page-wrapper {
        min-height: calc(100vh - 160px);
        display: flex;
        flex-direction: column;
    }

    .tools-page-section {
        padding: 80px 0;
        color: var(--text-main);
    }

    .tool-main-container {
        animation: fadeInUp 0.5s ease-out;
    }

    .tool-input-card {
        padding: 24px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }

    .tool-card-header {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 600;
        color: var(--accent-primary);
        margin-bottom: 20px;
        font-size: 1.1rem;
    }

    .parser-form textarea {
        width: 100%;
        background: rgba(0, 0, 0, 0.4);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 15px;
        color: #4ade80;
        font-family: 'Courier New', monospace;
        font-size: 1rem;
        transition: var(--transition);
        resize: vertical;
        outline: none;
    }

    .parser-form textarea:focus {
        border-color: var(--accent-primary);
        box-shadow: 0 0 10px var(--accent-glow);
    }

    /* --- Result Table --- */
    .result-card {
        padding: 24px;
    }

    .result-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .fields-table-wrapper {
        overflow-x: auto;
    }

    .fields-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 0.9rem;
    }

    .fields-table th {
        padding: 12px;
        color: var(--text-muted);
        font-size: 0.75rem;
        text-transform: uppercase;
        border-bottom: 2px solid var(--border-color);
        font-weight: 600;
    }

    .fields-table td {
        padding: 12px;
        border-bottom: 1px solid var(--border-color);
        color: var(--text-main);
    }

    .fields-table tr:hover {
        background: rgba(255, 255, 255, 0.03);
    }

    .field-id {
        font-weight: 700;
        color: var(--accent-primary);
        font-family: 'Courier New', monospace;
    }

    .error-banner {
        margin-top: 20px;
        background: rgba(248, 113, 113, 0.1);
        border: 1px solid #f87171;
        color: #f87171;
        padding: 12px;
        border-radius: 12px;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<?php include '../includes/footer.php'; ?>
