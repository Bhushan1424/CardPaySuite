
// Tools JS: Luhn, ISO bitmap inspector (basic), hex/ascii, base64
function luhnCheck(num){
  const s = String(num).replace(/\D/g,'');
  let sum=0, alt=false;
  for(let i=s.length-1;i>=0;i--){
    let d = parseInt(s.charAt(i),10);
    if(alt){ d*=2; if(d>9)d-=9; }
    sum+=d; alt=!alt;
  }
  return (sum%10)===0 && s.length>=12;
}
document.getElementById('luhn-check')?.addEventListener('click', ()=>{
  const v = document.getElementById('luhn-input').value.trim();
  const ok = luhnCheck(v);
  document.getElementById('luhn-result').textContent = ok ? '✅ Looks like a valid Luhn number.' : '❌ Invalid according to Luhn.';
});

// ISO 8583 Bitmap Inspector (basic)
// Expects hex input where MTI is ASCII (4 bytes) followed by primary bitmap (8 bytes = 16 hex chars)
// Example: MTI '0200' as ASCII hex is 30323030, so input could start with 30323030...
function hexToBytes(hex){ hex = hex.replace(/\s+/g,''); if(hex.length%2!==0) hex = '0'+hex; const out=[]; for(let i=0;i<hex.length;i+=2) out.push(parseInt(hex.substr(i,2),16)); return out; }
function bytesToAscii(bytes){ return bytes.map(b=> b>=32 && b<127 ? String.fromCharCode(b) : '.').join(''); }
document.getElementById('iso-parse')?.addEventListener('click', ()=>{
  const raw = document.getElementById('iso-input').value.replace(/\s+/g,'');
  if(!raw){ document.getElementById('iso-output').textContent='Paste hex (MTI + Primary Bitmap + data)'; return;}
  try{
    // read first 4 ASCII bytes for MTI (8 hex chars)
    const mtiHex = raw.substr(0,8);
    const mtiBytes = hexToBytes(mtiHex);
    const mti = bytesToAscii(mtiBytes);
    const bitmapHex = raw.substr(8,16);
    if(bitmapHex.length<16){ document.getElementById('iso-output').textContent='Input too short to contain primary bitmap.'; return; }
    const bitmapBytes = hexToBytes(bitmapHex);
    let bits='';
    for(const b of bitmapBytes){ bits += b.toString(2).padStart(8,'0'); }
    // build list of present fields (1..64)
    const present = [];
    for(let i=0;i<64;i++){ if(bits[i]=='1') present.push(i+1); }
    let out = 'MTI: '+mti + '\nPrimary bitmap hex: '+bitmapHex+'\nPresent fields: '+present.join(', ') + '\n(Inspector lists fields; it does not parse variable length fields automatically)';
    document.getElementById('iso-output').textContent = out;
  }catch(e){
    document.getElementById('iso-output').textContent = 'Error parsing input: '+e.message;
  }
});

// Hex <-> ASCII utilities
document.getElementById('hex-to-ascii')?.addEventListener('click', ()=>{
  const h = document.getElementById('hex-input').value.replace(/\s+/g,'');
  try{
    const bytes = hexToBytes(h);
    document.getElementById('hex-ascii-output').textContent = bytesToAscii(bytes);
  }catch(e){ document.getElementById('hex-ascii-output').textContent = 'Invalid hex'; }
});
document.getElementById('ascii-to-hex')?.addEventListener('click', ()=>{
  const s = document.getElementById('ascii-input').value || '';
  const arr = [];
  for(let i=0;i<s.length;i++) arr.push(s.charCodeAt(i).toString(16).padStart(2,'0'));
  document.getElementById('ascii-hex-output').textContent = arr.join('').toUpperCase();
});

// Base64 encode/decode
document.getElementById('b64-encode')?.addEventListener('click', ()=>{
  const s = document.getElementById('b64-input').value || '';
  try{ document.getElementById('b64-output').textContent = btoa(unescape(encodeURIComponent(s))); }catch(e){ document.getElementById('b64-output').textContent='Encode error'; }
});
document.getElementById('b64-decode')?.addEventListener('click', ()=>{
  const s = document.getElementById('b64-input').value || '';
  try{ document.getElementById('b64-output').textContent = decodeURIComponent(escape(atob(s))); }catch(e){ document.getElementById('b64-output').textContent='Decode error'; }
});
