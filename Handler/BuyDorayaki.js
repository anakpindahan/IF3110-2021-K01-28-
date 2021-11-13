function updateTotalHarga(){
  var BatasStok = document.getElementById("BatasStok").innerHTML;
  var intBatas = parseInt(BatasStok);
  var nilai = document.getElementById("amount-buy-num").value;
  var intNilai = parseInt(nilai);
  var harga = document.getElementById("hargaSatuan").innerHTML;
  var intHarga = parseInt(harga);
  if(intNilai >= 0){
    if(intNilai > intBatas){
      document.getElementById("amount-buy-num").value = intBatas;
      document.getElementById("TotalPriceLabelNum").innerHTML = intBatas * intHarga;
    }
    else{
      document.getElementById("TotalPriceLabelNum").innerHTML = intNilai * intHarga;
    }
  }
}

function plus(){
  var BatasStok = document.getElementById("BatasStok").innerHTML;
  var intBatas = parseInt(BatasStok);
  var nilai = document.getElementById("amount-buy-num").value;
  var intNilai = parseInt(nilai);
  var harga = document.getElementById("hargaSatuan").innerHTML;
  var intHarga = parseInt(harga);
  if(intNilai < intBatas){
    var totalHarga = (intNilai+1) * intHarga;
    document.getElementById("amount-buy-num").value = intNilai+1;
    document.getElementById("TotalPriceLabelNum").innerHTML = totalHarga;
  }
}

function plusAdmin(){
  var nilai = document.getElementById("amount-buy-num").value;
  var intNilai = parseInt(nilai);
  document.getElementById("amount-buy-num").value = intNilai+1;
}

function minus(){
  var nilai = document.getElementById("amount-buy-num").value;
  var intNilai = parseInt(nilai);
  var harga = document.getElementById("hargaSatuan").innerHTML;
  var intHarga = parseInt(harga);
  if(intNilai > 0){
    var totalHarga = (intNilai-1) * intHarga;
    document.getElementById("amount-buy-num").value = intNilai-1;
    document.getElementById("TotalPriceLabelNum").innerHTML = totalHarga;
  }
}
