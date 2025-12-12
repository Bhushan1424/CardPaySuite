
// Main JS: theme toggle, nav toggle - accessibility friendly
(function(){
  const themeToggle = document.getElementById('theme-toggle');
  const navToggle = document.getElementById('nav-toggle');
  const nav = document.getElementById('nav');
  function setTheme(t){
    document.body.setAttribute('data-theme', t);
    document.body.className = t;
    themeToggle.setAttribute('aria-pressed', t==='dark');
    themeToggle.textContent = t==='dark' ? '☀️' : '🌙';
    localStorage.setItem('cardpay-theme', t);
  }
  const saved = localStorage.getItem('cardpay-theme') || (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
  setTheme(saved);

  themeToggle && themeToggle.addEventListener('click', ()=>{
    setTheme(document.body.getAttribute('data-theme')==='dark'?'light':'dark');
  });

  if(navToggle && nav){
    navToggle.addEventListener('click', ()=>{
      const expanded = navToggle.getAttribute('aria-expanded') === 'true';
      navToggle.setAttribute('aria-expanded', String(!expanded));
      nav.style.display = expanded ? '' : 'block';
    });
  }
})();
