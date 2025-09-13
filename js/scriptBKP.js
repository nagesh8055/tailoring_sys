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
initEvent.onkeyup = (event)=>{
    addEvent(event, initEvent);
}

function addEvent(event, ele){
    if(event.key === 'Enter' || event.keyCode === 13) {
        event.preventDefault();

        let sel = ele.parentNode.parentNode.children[0].children[0];
        
        if(sel.selectedIndex>0){
            let val = sel.options[sel.selectedIndex].dataset.measurement; 
            $("#measurements-form").html("");

            $('#measurementModel').modal({
                show: true
            }); 

            let el = $("<div>");
            el.addClass("row");
            
            var mesurementArray = val.split(',');

            for( i = 0 ; i < mesurementArray.length ; i++ ){

                let innerDiv = $("<div>");
            innerDiv.addClass("form-group");
            innerDiv.addClass("col-2");
            innerDiv.append("<label for=\"recipient-name\" class=\"col-form-label\">"+mesurementArray[i]+"</label>");
            innerDiv.append("<input type=\"text\" class=\"form-control\" id=\"recipient-name\">");
            el.append(innerDiv);

            $("#measurements-form").append(el);

            }
        }else{
            alert("Please select Type");
        }
        
    }
}

$(document).on('click', '.add-fashion-dtl' , function() {
    //alert("ok");
    var data = 
    "<div class=\"col-6\">"+
        "<input type=\"text\" class=\"form-control\" id=\"inputPassword2\" placeholder=\"Fashion Details\">"+
    "</div>"
    +"<div class=\"col-3\">"+
    "<div class=\"form-check mt-1\">"+
        "<input class=\"form-check-input\" type=\"checkbox\" value=\"\" id=\"defaultCheck1\">"+
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

    let el = $("<div>");
    el.addClass("row");

    let divselect = $("<div>");
    divselect.addClass("col-3");
        let select = $("<select>")
        select.addClass("form-control");
    divselect.append(select);  
    
    var $options = $("#type > option").clone();
    $(select).append($options);

    let divRate = $("<div>");
    divRate.addClass("col-2");
        let inputRate = $("<input>")
            inputRate.attr("type","text");
            inputRate.addClass("form-control");
    divRate.append(inputRate);

    let divQty = $("<div>");
    divQty.addClass("col-2");
        let inputQty = $("<input>")
        inputQty.attr("type","text");
        inputQty.addClass("form-control");
    divQty.append(inputQty);    

    let divAdditionalDetail = $("<div>");
    divAdditionalDetail.addClass("col-3");
        let inputAD = document.createElement("input");
        inputAD.setAttribute("type","text");
        inputAD.classList.add("form-control");
        inputAD.onkeyup = (event)=>{
            addEvent(event, inputAD);
        }
    divAdditionalDetail.append(inputAD);
    divAdditionalDetail.addClass('additional-dtls');
    

    let divAddBtn = $("<div>");
    divRate.addClass("col-2");
        let btn = $("<button>")
            btn.attr("type","button");
            btn.addClass("btn"); 
            btn.addClass("btn-primary");
            btn.addClass("add-bill-dtl");
    divAddBtn.append(btn);        

    //el.html(data);
    el.append(divselect);
    el.append(divRate);
    el.append(divQty);
    el.append(divAdditionalDetail);
    el.append(divAddBtn);


    $( "#billItems" ).append(el);                
    
    // Kartik Desai - 7620137072
});

//billItems