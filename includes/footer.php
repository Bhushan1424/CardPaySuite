<footer>
© 2026 Card Pay Suite
</footer>

<script>
document.addEventListener("DOMContentLoaded", function () {

  console.log("JS Loaded ✅");

  // ✅ Safe Card Input Formatting
  let cardInput = document.getElementById("cardInput");
  if (cardInput) {
    cardInput.addEventListener("input", function(e){
      let value = e.target.value.replace(/\D/g, "");
      value = value.substring(0,16);
      value = value.replace(/(.{4})/g, "$1 ").trim();
      e.target.value = value;
    });
  }

  // ✅ Drag & Drop Safe Handling
  let card = document.getElementById("card");
  let terminal = document.getElementById("terminal");

  if (card && terminal) {

    card.draggable = true;

    card.addEventListener("dragstart", function(e){
      e.dataTransfer.setData("text","");
    });

    terminal.addEventListener("dragover", function(e){
      e.preventDefault();
    });

    terminal.addEventListener("drop", function(){

      let terminalText = document.getElementById("terminalText");
      if (terminalText) {
        terminalText.innerText = "Tap Successful";
      }

      startTransaction();

    });

  }

});


// ✅ Payment Flow (for .payment-flow UI if used)
function runPaymentFlow(){

  let steps = document.querySelectorAll('.payment-flow .step');

  steps.forEach(s => s.classList.remove('active'));

  steps.forEach((step,index)=>{
    setTimeout(()=>{
      step.classList.add('active');
    }, index * 700);
  });

}


// ✅ MAIN TRANSACTION FLOW (ONLY ONE VERSION)
function startTransaction(){

  let nodes = ["merchant","acquirer","switch","network","issuer"];

  nodes.forEach((id,index)=>{

    let el = document.getElementById(id);

    if (el) {
      setTimeout(()=>{
        el.classList.add("active");
      }, index * 800);
    }

  });

}
</script>

</body>
</html>