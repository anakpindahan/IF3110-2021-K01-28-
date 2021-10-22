function increment(e, price, amount) {
    e.preventDefault();
    if(document.getElementById("amount-buy-num").value < amount){
      document.getElementById("amount-buy-num").stepUp();
      price = price * document.getElementById("amount-buy-num").value
      document.getElementById("total-price-num").innerHTML = price.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    }
  }
  
  function decrement(e, price) {
    e.preventDefault();
    if(document.getElementById("amount-buy-num").value > 1){
        document.getElementById("amount-buy-num").stepDown();
        price = price * document.getElementById("amount-buy-num").value
        document.getElementById("total-price-num").innerHTML = price.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");;
    } 
  }