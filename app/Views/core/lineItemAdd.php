<?php ?>
<div class="col-lg-8 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Simple Budget</h4>
          <div class="table-responsive">
          <table class="table" id="tab_logic">
            <thead>
              <tr>
                <th><b>Sl.no<b></th>
                <th><b>Line Item Name</b></th>
                <th><b>Unit Price</b></th>
                <th><b>Quantity</b></th>
                <th><b>Tax (5%)</b></th>
              </tr>
            </thead>
            <tbody>
              <tr id='lineitems1'></tr>
            </tbody>
          </table>
        </div>
    </div>
  </div>
</div>
<div class="col-lg-4 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Simple Budget- Add Line Item</h4>
      <form class="forms-sample" id="myForm">
        <div class="form-group">
          <label for="exampleInputUsername1">Line Item Name</label>
          <input type="text" class="form-control" id="lineitemname" placeholder="lineitemname">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Unit Price</label>
          <input type="text" class="form-control" id="price" placeholder="price">
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Quantity</label>
          <input type="number" class="form-control" id="quantity" placeholder="Quantity">
        </div>
        <div class="form-group">
          <label for="exampleInputConfirmPassword1">Tax</label>
          <input type="text" class="form-control" id="tax" placeholder="tax">
        </div>
        <button type="button" id="add_row" class="btn btn-primary me-2">Submit</button>
        <button class="btn btn-light" id="reset-row">Cancel</button>
      </form>
    </div>
  </div>
</div>
<div class="col-lg-12 grid-margin stretch-card">
<div class="card">
    <div class="card-body">
      <h4 class="card-title">Simple Budget- Add Discount</h4>
      <form class="forms-sample" id="myFormDsi">
        <div class="form-group">
          <label for="exampleInputUsername1">Discount Percentage</label>
          <input type="text" class="form-control" id="discountpercentage" placeholder="discountpercentage">
        </div>
        <button type="button" id="add_dis" class="btn btn-primary me-2">Calculate Discount Percentage</button>
        <button class="btn btn-light" id="reset-row">Cancel</button>
      </form>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<script>
  jQuery(document).ready(function() {
  var i = 1;
  var totalPriceWithoutTax =0;
  var totalPriceWithTax =0;
  var totalQuantity =0;
  var totalTaxCollected =0;
  var lineitemwithtax = 0;
  jQuery("#add_dis").click(function() {
    var discountvalue = parseFloat(document.getElementById("discountpercentage").value);
    var amountWithTax = parseFloat(localStorage.getItem("totalPriceWithTax"));
    var reduction = parseFloat(getDiscoutAmount(amountWithTax,discountvalue ));
    var finalAmountWithTax = amountWithTax - reduction;
    localStorage.setItem("totalPriceWithTaxDiscount", finalAmountWithTax);
    console.log(discountvalue);console.log(amountWithTax);console.log(reduction);
    document.getElementById("demo5").innerHTML = localStorage.getItem("totalPriceWithTaxDiscount");
    document.getElementById("myFormDsi").reset();
  });
  jQuery("#reset-row").click(function() {
    var totalPriceWithoutTax =0;
    var totalPriceWithTax =0;
    var totalQuantity =0;
    var totalTaxCollected =0;
    var lineitemwithtax = 0;
    document.getElementById("myForm").reset();
    localStorage.clear();
  });
  jQuery("#add_row").click(function() {
    var lineitem = document.getElementById("lineitemname").value;
    var lineitemprice = parseFloat(document.getElementById("price").value);
    var lineitemquantity = parseInt(document.getElementById("quantity").value);
    var lineitemTax = parseFloat(document.getElementById("tax").value);
    jQuery('tr').find('input').prop('disabled',true)
    jQuery('#lineitems' + i).html("<td>" + (i) + "</td><td>"+lineitem+"</td><td>"+lineitemprice+"</td><td>"+lineitemquantity+"</td><td>"+lineitemTax+"</td>");
    jQuery('#tab_logic').append('<tr id="lineitems' + (i + 1) + '"></tr>');
    i++;
    document.getElementById("myForm").reset();
    
    totalTaxCollected = totalTaxCollected+lineitemTax;
    totalQuantity = totalQuantity+lineitemquantity;
    lineitemwithtax = lineitemwithtax+(lineitemprice+getTax(lineitemprice, lineitemTax,lineitemquantity));
    totalPriceWithoutTax = totalPriceWithoutTax+lineitemprice*lineitemquantity;
    totalPriceWithTax = totalPriceWithTax+(lineitemprice*lineitemquantity)+getTax(lineitemprice, lineitemTax,lineitemquantity);
    console.log(totalPriceWithTax);
    
    localStorage.setItem("totalPriceWithTax", totalPriceWithTax);
    localStorage.setItem("totalTaxCollected", totalTaxCollected);
    localStorage.setItem("totalQuantity", totalQuantity);
    localStorage.setItem("totalPriceWithoutTax", totalPriceWithoutTax);

    document.getElementById("demo1").innerHTML = localStorage.getItem("totalPriceWithTax");
    document.getElementById("demo2").innerHTML = localStorage.getItem("totalPriceWithoutTax");
    document.getElementById("demo3").innerHTML = localStorage.getItem("totalQuantity");
    document.getElementById("demo4").innerHTML = localStorage.getItem("totalTaxCollected");
  });

  function getTax(amount, tax, quantity) {
    var taxPec = (tax/100);
    var totaltax = amount*taxPec*quantity;
    return parseFloat(totaltax);
  }
  function getDiscoutAmount(amount, discount) {
    var discountPec = (discount/100);
    var totaldiscount = amount*discountPec;
    console.log("totaldiscount"+discount);
    return parseFloat(totaldiscount);
  }

});
</script>