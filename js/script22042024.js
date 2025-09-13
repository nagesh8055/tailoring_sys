    // Function to calculate total
    

    function calculateTotal() {
        var total = 0;
        var count = 0;
        $('input[name="rate[]"]').each(function(index) {
            var rate = parseFloat($(this).val());
            var qty = parseFloat($('input[name="qty[]"]').eq(index).val());
            if (!isNaN(rate) && !isNaN(qty)) {
                total += rate * qty;
            }
            count++;
        });
        //alert(total.toFixed(2));
        
        $('#total-bill-amount').html(total.toFixed(2)); // Display total
        $('#total-bill-items').html(count); // Display total
    }

    $(document).on('input','.rate, .qty', function(){
        //var total = calculateTotal();
        //$('#total-bill-amount').html(total);
        calculateTotal();
    });

    // Calculate total on input change
    $('.rate, .qty').on('input', function() {
        var total = calculateTotal();
        $('#total-bill-amount').text(total);
    });

$(function(){

    $( "#create-link" ).click(function(event)
    {
        event.preventDefault();
        var userUrl= $("#userurl").val();

        $.ajax(
            {
                type:"post",
                url: "createlink",
                data:{ userUrl:userUrl},
                success:function(response)
                {

                    var data = JSON.parse(response);
                    $('#create-url-response').html(data.message);
                    $('#create-url-response1').html(data.surl);

                    /*alert(response);
                    console.log(response);
                    $("#message").html(response);
                    $('#cartmessage').show();*/
                },
                error: function() 
                {
                    alert("Invalide!");
                }
            }
        );
    });
});
// new invention
let initEvent = document.getElementById("initEvent");
let hiddenFiledId = "mhf01";
if(initEvent != null && initEvent != '') {
    //
    initEvent.onkeyup = (event)=>{
        addEvent(event, initEvent, hiddenFiledId );
    }
}

 // Function to add checkbox
 function addCheckbox(container, name , label) {
    var checkbox = $('<input>').attr({
        type: 'checkbox',
        name: name,
        id: name
    });
    var label = $('<label>').attr('for', name).text(label).addClass('mr-2');
    container.append(checkbox, label);
}

function addEvent(event, ele , hiddenFiledId  ){
    //alert(hiddenFiledId);
    if(event.key === 'Enter' || event.keyCode === 13) {
        event.preventDefault();

        $("#measurements-form").html("");
        $("#fashion-form").html("");
        
           let sel = ele.parentNode.parentNode.children[0].children[0];
        
        if(sel.selectedIndex>0){
            let val = sel.options[sel.selectedIndex].dataset.measurement; 
            
            
            var typeId = sel.options[sel.selectedIndex].value;


            $('#measurementModel').modal({
                show: true
            }); 
            $("#get-billdetails-form").attr('targethiddenfield', hiddenFiledId);

            let el = $("<div>");
            el.addClass("row");
            
            //var mesurementArray = val.split(',');
            $.ajax({
                url: "getMeasurementByTypeId/"+typeId,
                type: "GET",
                dataType: "json",
                success: function(response1) {
                    //console.log(response);
                    for (var i = 0; i < response1.length; i++) {
                        var obj = response1[i];
                        //alert(obj);
                         let innerDiv = $("<div>");
                        innerDiv.addClass("form-group");
                        innerDiv.addClass("col-2");
                        innerDiv.append("<label for=\"recipient-name\" class=\"col-form-label\">"+obj.m_name+"</label>");
                        //innerDiv.append("<input type=\"text\" class=\"form-control mesurementinputfield\" name=\""+obj.m_name+"-"+obj.type_id+"\">");
                        let inputMeasurementTestField = $("<input>");
                            inputMeasurementTestField.attr("type","text");
                            inputMeasurementTestField.attr("name",obj.m_name+"-"+obj.type_id);
                            inputMeasurementTestField.addClass("form-control mesurementinputfield");

                            //Formatted Text Field
                            if(obj.is_custom == 0 ) { //25 Mar
                                inputMeasurementTestField.on('input', formattedInputEvent);
                            }
                            
                            //end of formatted text field

                        innerDiv.append(inputMeasurementTestField);    
                        
                        el.append(innerDiv);
            
                        $("#measurements-form").append(el);
                        
                        
                    }
                    
                },
                error: function(xhr, status, error) {
                    // Handle errors here
                    console.error(xhr.responseText);
                }
            });
           
            //Fashion Details
            $.ajax({
                url: "getFashionMData/"+typeId,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    //alert(response);

                    for (var i = 0; i < response.length; i++) {
                        var obj = response[i];
                        
                        //alert(obj.subfashions);

                        var subFashionArray = obj.subfashions.split(','); 
                        var subFashionIdArray = obj.subfashionsid.split(','); 

                        var fieldset = $('<fieldset>').addClass('border p-1');
                        // Add legend to the fieldset
                        var legend = $('<legend style="font-size:12pt;">').text(obj.f_name).appendTo(fieldset);
                        
                        // Add inner fieldset for checkboxes
                        var innerFieldset = $('<fieldset>').addClass('p-1').appendTo(fieldset);
                        // Add checkboxes inside inner fieldset

                            for ( j = 0 ; j < subFashionArray.length; j++ ) {
                                //for 2nd parameter combination is : fashion_master id + sub fashion Id
                                addCheckbox(innerFieldset, obj.fid+"_"+subFashionIdArray[j], subFashionArray[j] );      
                            }

                        //addCheckbox(innerFieldset, 'name1');
                        //addCheckbox(innerFieldset, 'name2');
                        //addCheckbox(innerFieldset, 'name3');
                        
                        // Append the new fieldset to the container
                        $('#fashion-form').append(fieldset);
                    }
                    // Handle the response here
                    //alert('Name: ' + response.name + ', Age: ' + response.age);
                },
                error: function(xhr, status, error) {
                    // Handle errors here
                    console.error(xhr.responseText);
                }
            });

        }else{
            alert("Please select Type");
        }
        
    }
}

$(document).on('click','.assign-job', function(){
    var status = $(this).data('jobstatus');
    var jobId = $(this).data('jobid');
    var workerName = $(this).data('wname');
    var type = $(this).data('type');

    $("#tjobid").val(jobId);
    $("#tworkerid").val($(this).data('workerid'));
    $("#tworker").val(workerName);
    $("#tstatus").val(status);
    $("#type").val(type);
    
    var workerList= null;
    if(status == 0 || status == 2 ) { // Assign Job First Time

        $.ajax({
            url: "getWorkerList/"+status,
            type: "GET",
            dataType: "json",
            success: function(response1) {
                //console.log(response);
                $("#workerselect").html("");
                $("#workerselect").append("<option>Select</option>");
                for (var i = 0; i < response1.length; i++) {
                    var obj = response1[i];
                    $("#workerselect").append("<option value='" + obj.w_id + "'>" + obj.name + "</option>");
                }
            },
            error: function(xhr, status, error) {
                // Handle errors here
                console.error(xhr.responseText);
            }
        });

    }

    if(status == 1) { // Submit JOb

    }
    
    $('#assignJobModal').modal({
        show: true
    }); 

    
});

$(document).on('click', '.add-fashion-dtl' , function() {
    //alert("ok");
    var data = 
    "<div class=\"col-6\">"+
        "<input type=\"text\" class=\"form-control\" name=\"fdtl[]\" placeholder=\"Fashion Details\">"+
    "</div>"
    +"<div class=\"col-3\">"+
    "<div class=\"form-check mt-1\">"+
        "<input class=\"form-check-input\" type=\"checkbox\" value=\"\" name=\"fdtlchk[]\">"+
        "<label class=\"form-check-label\" for=\"defaultCheck1\">"+
            "Visible"+
        "</label>"+
    "</div>"+
    "</div>"+
    "<div class=\"col-3 \">"+
        "<button type=\"button\" class=\"btn btn-primary mb-3 add-fashion-dtl\">New</button>"+
    "</div>";

    let el = $("<div>");
    el.addClass("row");
    el.html(data);
    $( "#subFashionSection" ).append(el);                
    
    //Kartik Desai - 7620137072
});

$(document).on('click', '.add-bill-dtl' , function() {
    
    var timestamp = Date.now();
    var timestampInSeconds = Math.floor(timestamp / 1000);    
    

    let el = $("<div>");
    el.addClass("row");
    
    var $options = $("#type > option").clone();
    $("#type").removeAttr("id");

    let divselect = $("<div>");
    divselect.addClass("col-3");
        let select = $("<select>")
        select.addClass("form-control");
        select.addClass("select-type");
        select.attr("id","type")
        select.attr("name","type[]")
        
    divselect.append(select);  

    
    
    
    $(select).append($options);

    let divRate = $("<div>");
    divRate.addClass("col-2");
        let inputRate = $("<input>")
            inputRate.attr("type","text");
            inputRate.addClass("form-control");
            inputRate.addClass("rate");
            inputRate.attr("name","rate[]")
    divRate.append(inputRate);

    let divQty = $("<div>");
    divQty.addClass("col-2");
        let inputQty = $("<input>")
        inputQty.attr("type","text");
        inputQty.addClass("form-control qty");
        inputQty.attr("name","qty[]")
    divQty.append(inputQty);    

    let divAdditionalDetail = $("<div>");
    divAdditionalDetail.addClass("col-3");
        let inputAD = document.createElement("input");
        inputAD.setAttribute("type","text");
        inputAD.setAttribute("name","additionaldtl[]");

        inputAD.classList.add("form-control");
        inputAD.onkeyup = (event)=>{
            addEvent(event, inputAD, "mhf"+timestampInSeconds+"");
        }
    divAdditionalDetail.append(inputAD);
    divAdditionalDetail.addClass('additional-dtls');

    // Create a hidden input element
    var hiddenFieldMeasurement = $('<input>');
    // Set the type attribute to 'hidden'
    hiddenFieldMeasurement.attr('type', 'hidden');

    // Set any other attributes if needed
    hiddenFieldMeasurement.attr('name', 'measurements[]');
    hiddenFieldMeasurement.attr('id', "mhf"+timestampInSeconds+"");
    divAdditionalDetail.append(hiddenFieldMeasurement);
    

    let divAddBtn = $("<div>");
    divAddBtn.addClass("col-2");
        let btn = $("<button>")
            btn.attr("type","button");
            btn.html("add");
            btn.addClass("btn"); 
            btn.addClass("btn-success");
            btn.addClass("mb-3");
            btn.addClass("add-bill-dtl");
    divAddBtn.append(btn);        

    //el.html(data);
    el.append(divselect);
    el.append(divRate);
    el.append(divQty);
    el.append(divAdditionalDetail);
    el.append(divAddBtn);


    $(this).html("Remove");
    $(this).removeClass("add-bill-dtl");
    $(this).removeClass("btn-success");
    $(this).addClass("btn-danger");
    $(this).addClass("remove-bill-dtl");

    $( "#billItems" ).prepend(el);
    
  
    
    
});

$(document).on('click', '.remove-bill-dtl' , function() {

    $(this).parent().parent().remove();
    calculateTotal();

});

$(document).on('change', '.select-type' , function() {
    var selectedValue = $(this).val();
    var rate = $(this).find('option:selected').data('rate');
    var a = $(this).parent().parent();//.children('.rate').val(rate);//.find('input[type="text"]');
    a.find('.rate').val(rate);


    //$(inputElement).val(rate);
});

//start 17 Mar
$(document).on('change','#customer_worker', function(){
    var selectedValue = $(this).val();
    var osAmt = $(this).find('option:selected').data('camt');
    $("#totalOustandingInput").val(osAmt);
});

$('#amountInput').on('input', function() {
    
    var amt = $(this).val();
    var totalOs = $("#totalOustandingInput").val();
    $("#remainingAmountInput").val(totalOs-amt);
});

//end of 17 mar

$(document).ready(function() {
    $('#selectFilter').on('input', function() {
        var searchText = $(this).val().toLowerCase();
        
        $('#exampleFormControlSelect1 option').each(function() {
            var optionText = $(this).text().toLowerCase();
            var optionValue = $(this).val();
            
            if (optionText.includes(searchText)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});



$(document).ready(function() {

    //$('.avighna-form').preventDefault();

    $('.avighna-form').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) { 
          e.preventDefault();
          return false;
        }
      });

      $('#get-billdetails-form').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) { 
          e.preventDefault();
          return false;
        }
      });

      

    $('.avighna-form').submit(function(e) {
        

        var formData = new FormData(this);
        var successResponse = $(this).data('successresponse');
        var isResetForm = $(this).data('reset');
        var form = $(this);

        e.preventDefault();
        //alert($(this).data('action'));
        $.ajax({
            url: $(this).data('action'),
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if(isResetForm == "yes") {
                    $(form)[0].reset();
                }
                $('#response').html(response);
                var successAlert =     
                '<div class="alert alert-warning alert-dismissible fade show" role="alert">'
                    +'<strong>'+response+'</strong>'
                    +'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                        +'<span aria-hidden="true">&times;</span>'
                    +'</button>'
                +'</div>';
                
                $("#"+successResponse+"").html(successAlert);

            }
        });
    });

    //BillDetails
    $('#get-billdetails-form').submit(function(e) {
        e.preventDefault();
        
         // Serialize form data into an array of objects
         var formDataArray = $(this).serializeArray();

         // Convert array into JSON string
         var formDataJSON = JSON.stringify(formDataArray);

         var hiddenFiled = $(this).attr('targethiddenfield');
         $("#"+hiddenFiled+"").val(formDataJSON);

         alert("Mesurements & Fashion Added Successfully");

         $('#measurementModel').modal('hide');
        //alert($(this).attr('targethiddenfield'));
    });
});

//25 Mar
$(document).on('click','.edit-measurement', function(){
   // alert($(this).data('mid'));
    //let formId = 'measurement-form';
    $('#measurementform')[0].reset();
    $('#measurementform input[name="m_id"]').val($(this).data('mid'));
    $('#measurementform input[name="m_name"]').val($(this).data('mname'));
    
    if(($(this).data('visible') == 1 )) {
        $('#measurementform input[name="visible"]').prop('checked', true);
    }
    if($(this).data('custom') == 1) {
        $('#measurementform input[name="custom_input"]').prop('checked', true);
    }
    
    

    //visible,custom_input
    $('#measurementform select[name="type_id"]').val($(this).data('mtype'));
    

});
function formattedInputEvent( event) {

    
    //alert($(this).val());
    //var inputField = event;
    let value = $(this).val();
    
    // Remove non-numeric characters
    //value = value.replace(/[^\d]/g, '');

    // Format as "00-|||"
    if (value.length > 2) {
        value = value.substring(0, 2) + '-' + value.substring(2);
    }
    if (value.length > 3) {
        //alert(value.substring(3));
        var bar = '';
        for(i =0 ; i < value.substring(3) ; i++){
            bar = bar +'|';
        }
        //value = value.substring(0, 5) + '|';
        value = value.substring(0, 3) + bar;
    }

    $(this).val(value);
}

    

//billItems