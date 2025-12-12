<?php
// Optional server-side fallback for small tasks (e.g., if client can't run JS). Not used by default.
// This script does NOT log inputs. It echoes results immediately and returns.
header('Content-Type: application/json; charset=utf-8');
$action = $_GET['action'] ?? '';
$input = $_POST['input'] ?? '';
if($action === 'luhn'){
    $s = preg_replace('/\D/','',$input);
    $sum=0;$alt=false;
    for($i=strlen($s)-1;$i>=0;$i--){
        $d = intval($s[$i]);
        if($alt){ $d*=2; if($d>9) $d-=9; }
        $sum += $d; $alt = !$alt;
    }
    echo json_encode(['ok'=> ($sum%10===0) && strlen($s)>=12]);
    exit;
}
echo json_encode(['error'=>'unknown action']);
?>