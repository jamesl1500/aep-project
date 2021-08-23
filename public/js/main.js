$(document).ready(function()
{
    var mainOverlay = $("body");
    var navbarHovers = $(".hoverLi");
    var navbarDropdown = $(".hasDropdown");
    var sidebar = $(".sidebar");
    var website = $(".websiteBody");

    $(document).on('keyup', '.searchBarMain', function(){

    });

    $('.modal').insertBefore($('body'));


    //$('#shippingModal').modal();  
    //$('#orderStatusChange').modal();  

    $(document).on('click', '.searchBarBtn-index', function(){
        if($(".searchBarMain-index").val() != "")
        {
            window.location.assign("/search?s=" + $(".searchBarMain-index").val());
        }
    });

    $(document).on('click', '.searchBarBtn-header', function(){
        if($(".searchBarMain-header").val() != "")
        {
            window.location.assign("/search?s=" + $(".searchBarMain-header").val());
        }
    });
    
    // Product size select
    $(document).on('click', '.selectSystem', function(){
        var value = $(this).data('value');

        if(value != "")
        {
            $(".selectSystem").removeClass("active");
            $(this).addClass("active");

            // Select
            $("#sizeSelect").val(value);

            // Remove disabled class
            $(".addToCartBtn").removeClass("disabled");
            $(".addToCartBtn").prop("disabled", false);

            // Change text
            $(".sizeText").html($(this).html());

            // Slide up
            $(".buttonDropdown").slideUp('fast');
        }
    });

    $(document).on('click', '.buttonInner', function(){
        $(".buttonDropdown").slideToggle();
    });


    // Sidebar function
    $(document).on('click', '.retractSidebar', function(e){
        e.preventDefault();

        mainOverlay.css('overflow', 'auto');
        $(".mainWebsiteHold").css('overflow', 'auto');

        website.animate({'left': '0px'}, '', '', function(){
            $(".websiteMainOverlay").fadeOut('fast');
            $(".sidebar").fadeOut('fast');
        });

        return false;
    });

    $(document).on('click', '.openSidebar', function(e){
        e.preventDefault();

        mainOverlay.css('overflow', 'hidden');
        $(".mainWebsiteHold").css('overflow', 'hidden');

        website.animate({'left': '260px'}, '', '', function(){
            $(".websiteMainOverlay").fadeIn('fast');
            $(".sidebar").fadeIn('fast');
        });

        return false;
    });

    // Fade overlay function
    function mainWebsiteOverlay()
    {
        mainOverlay.fadeIn();
    }

    mainWebsiteOverlay();

    // Navbar hover
    navbarHovers.hover(function(e){
        e.stopPropagation();
        $(this).children(".dropdownBox").fadeIn('slow');
        return false;
    }, function(e){
        e.stopPropagation();
        $(this).children(".dropdownBox").fadeOut('slow');
        return false;
    });

    // Navbar buttons
    navbarDropdown.on('click', function(){
        var open = $(this).data('open');

        if(open != "")
        {
            // Means its open
            if($(this).hasClass('active'))
            {
                $("." + open).fadeOut('fast');
                $(this).removeClass('active');
            }else{
                $("." + open).fadeIn('fast');
                $(this).addClass('active');
            }
        }
    });

    $("#returnPolicyForm").submit(function(){
        var token = $("#csrf");
        
        $.post("/exitReturnPolicy", {_token: token.val()}, function(data){
           $(".returnPolicyAction").fadeOut('fast');
           $(".over").fadeOut('fast');
        });
        return false;
    });

    // For product delete
    $(".productDelete").on('click', function(e){
        e.preventDefault();

        var pid = $(this).data('pid');
        var token = $(this).data('t');

        if(pid != "" && token != "")
        {
            var c = confirm("Are you sure you want to delete this product?");

            if(c == true)
            {
                $.post("/products/delete", {_token: token, pid: pid}, function (data) {
                    $("#product" + pid).fadeOut('slow');
                });
            }
        }
        return false;
    });

    // For product editing
    /*$("#productEditForm").on('submit', function(e){
        e.preventDefault();

        var token = $(this).data('t');

        var form = $(this);
        var pid = form.children("input[type='hidden'][name='pid']").val();

        var dataSend = form.serialize();

        if(pid != "" && token != "")
        {
            var c = confirm("Are you sure you want to edit this product?");

            if(c == true)
            {
                // File upload checks
                var fileSource = $("#product_image");
                var thumbSource = $("#product_image_thumbnails");

                if(fileSource.val() != "" || thumbSource.val() != "")
                {
                    // Means we have a file
                    var fileData = new FormData();

                    var files = fileSource[0].files[0];
                    var thumbs = thumbSource[0].files;

                    fileData.append('product_image', files);
                    fileData.append('product_image_thumbnails', thumbs);
                    fileData.append('product_title', $("#product_title").val());
                    fileData.append('product_desc', $("#product_desc").val());
                    fileData.append('product_tags', $("#product_tags").val());
                    fileData.append('product_price', $("#product_price").val());
                    fileData.append('product_gender', $("#product_gender").val());
                    fileData.append('product_brand', $("#product_brand").val());
                    fileData.append('product_category', $("#product_category").val());
                    fileData.append('product_sub_category', $("#product_sub_category").val());
                    fileData.append('product_sizing', $("#product_sizing").val());
                    fileData.append('weight', $("#weight").val());
                    fileData.append('length', $("#length").val());
                    fileData.append('width', $("#width").val());
                    fileData.append('height', $("#height").val());
                    fileData.append('_token', $("#_token").val());
                    fileData.append('pid', $("#pid").val());

                    $.ajax({
                        url: '/products/edit',
                        type: 'post',
                        data: fileData,
                        contentType: false,
                        processData: false,
                        success: function(response){
                            if(response != 0){
                                //$("#img").attr("src",response);
                                alert('Product has been updated');
                            }else{
                                alert('file not uploaded');
                            }
                        }
                    });

                }else {
                    $.post("/products/edit", dataSend, function (data) {
                        alert('Product has been updated');
                    });
                }
            }
        }
        return false;
    });*/

    // Product sizing
    $(document).on("click", ".addSize", function(){
        addRow('productSizeHold');
    });

    $(document).on("click", ".eraseSize", function(){
        
        $(this).closest('tr').fadeOut("slow", function(){
            $(this).remove();
        });
    });
    
    function addRow(tableID) {
        var table = document.getElementById(tableID).getElementsByTagName('tbody')[0];
        var rowCount = table.rows.length;
        if(rowCount < 10){                            // limit the user from creating fields more than your limits
            var row = table.insertRow(rowCount);
            var colCount = table.rows[0].cells.length;
            for(var i=0; i <colCount; i++) {
                var newcell = row.insertCell(i);
                newcell.innerHTML = table.rows[0].cells[i].innerHTML;
            }
        }else{
            alert("Maximum Passenger per ticket is 5");

        }
    }

    function deleteRow(tableID) {
        var table = document.getElementById(tableID);
        var rowCount = table.rows.length;
        for(var i=0; i<rowCount; i++) {
            var row = table.rows[i];
            var chkbox = row.cells[0].childNodes[0];
            if(null != chkbox && true == chkbox.checked) {
                if(rowCount <= 1) {               // limit the user from removing all the fieldalert("Cannot Remove all the Passenger.");
                    break;
                }
                table.deleteRow(i);
                rowCount--;
                i--;
            }
        }
    }

    // Cart

    // Manage orders
    $(".order-table").DataTable();
    
    // Checkout
    var address_1 = $("#address_one");
    var address_2 = $("#address_two");
    var city = $("#city");
    var state = $("#state");
    var zip_code = $("zip_code");

    $(document).on('click', '#calculate_shipping', function(e)
    {
        e.preventDefault();

        // Make sure the address is clear
        if(address_1.val() && city.val() != "" && state.val() != "" && zip_code.val() != "")
        {
            // Calculate shipping using ajax call
            $.post('/shipping/calculate', {_token: $("#ajax_token").val(), address_one: address_1.val(), address_two: address_2.val(), city: city.val(), state: state.val(), zip_code: zip_code.val()}, function(data)
            {
                var obj = jQuery.parseJSON(data);

                $(".innerShipping").html("");

                $.each(obj, function(index, value)
                {
                    if(value.service != "Express") {
                        // Create temp
                        var temp = "<div class='shippingMod clearfix'>";
                        temp += "<div class='col-lg-1 shipping-actions'>";
                        temp += "<input type='radio' name='shipping' value='"+value.rate_id+ "|" + value.service + "|"+value.carrier+"|"+value.price+"|"+value.shipment_id+"|"+value.est_delivery+"'>";
                        temp += "</div>";
                        temp += "<div class='col-lg-10 shipping-main'>";
                        temp += "<div class='shipping-visible'>";

                        if (value.service == "First") {
                            temp += "<h3><b>" + value.carrier + " - " + value.service + " Class</b></h3>";
                        }else{
                            temp += "<h3><b>" + value.carrier + " - " + value.service + "</b></h3>";
                        }
                        if (value.est_delivery == null || value.est_delivery == "") {
                            temp += "<h4><b>$" + value.price + "</b></h4>";
                        } else {
                            temp += "<h4><b>$" + value.price + "</b> &middot; Est Delivery: " + value.est_delivery + " Day(s)</h4>";
                        }
                        temp += "</div>";
                        temp += "<div class='shipping-hidden-info'>";

                        temp += "</div>";
                        temp += "</div>";
                        temp += "</div>";
                    }

                    // Append
                    $(".innerShipping").append(temp);
                });
            });
        }else{
            alert("Please enter your shipping address");
        }
        return false;
    });

    $(document).on('click', 'input:radio[name=shipping]:checked', function()
    {
        if($("#order-total").hasClass('hidden'))
        {
            $("#order-total").removeClass('hidden');
        }

        // Get shipping info
        var info = $(this).val().split('|');

        // New total
        var subtotal = parseInt($("#subtotal").val()) + parseInt(info[3]);

        $("#order-total-number").html("$" + subtotal);
    });
    
    $(document).on('click', '.removeThumbnail', function(e){
        e.preventDefault();
        //var confirm = confirm("Are you sure you want to delete this photo?");
        
        if(1 == 1)
        {
            // Go ahead
            var token = $(this).data('tdotgoonscrapdvd');
            var pid = $(this).data('pid');
            var tid = $(this).data('thumbid');

            // Post
            $.post('/products/edit/removeThumbnail', {_token: token, pid: pid, thumbid: tid}, function(data){
                var obj = jQuery.parseJSON(data);

                if(obj.code == 1)
                {
                    $("#thumb" + tid).fadeOut('fast');
                }else{
                    alert(obj.message);
                }
            });
        }
    });
    
    $(document).on('click', '.thumb', function(e){
        e.preventDefault();

        var src = $(this).data('src');

        if(src != "")
        {
            $(".primaryImage").attr('src', src);

            $(".thumb").each(function(){
                $(this).removeClass('thumbActive');
            });

            $(this).addClass("thumbActive");
        }
    });
    
    $(document).on('click', '.adminRevoke', function(e){
       e.preventDefault();
        
        var id = $(this).data('id');
        var href = $(this).attr('href');
        
        if(id != "")
        {
            $.post(href, {_token: $(this).data('token'), id: id}, function(data){
               var obj = jQuery.parseJSON(data);

               if(obj.code == 1){
                   window.location.reload();
               } else{
                   alert(obj.status)
               }
            });
        }
        
        return false;
    });

    $(document).on('click', '.adminMake', function(e){
        e.preventDefault();

        var id = $(this).data('id');
        var href = $(this).attr('href');

        if(id != "")
        {
            $.post(href, {_token: $(this).data('token'), id: id}, function(data){
                var obj = jQuery.parseJSON(data);

                if(obj.code == 1){
                    window.location.reload();
                } else{
                    alert(obj.status)
                }
            });
        }

        return false;
    });

    $(document).on('click', '.adminActivate', function(e){
        e.preventDefault();
         
         var id = $(this).data('id');
         var href = $(this).attr('href');
         
         if(id != "")
         {
             $.post(href, {_token: $(this).data('token'), id: id}, function(data){
                var obj = jQuery.parseJSON(data);
 
                if(obj.code == 1){
                    window.location.reload();
                } else{
                    alert(obj.status)
                }
             });
         }
         
         return false;
     });
 
     $(document).on('click', '.adminDeactivate', function(e){
         e.preventDefault();
 
         var id = $(this).data('id');
         var href = $(this).attr('href');
 
         if(id != "")
         {
             $.post(href, {_token: $(this).data('token'), id: id}, function(data){
                 var obj = jQuery.parseJSON(data);
 
                 if(obj.code == 1){
                     window.location.reload();
                 } else{
                     alert(obj.status)
                 }
             });
         }
 
         return false;
     });

     $.fn.editable.defaults.params = function (params) {
        params._token = $(".change").data("token");
        return params;
    };

    $(".change").editable({
        'source': [{value: 1, text: "Yes"}, {value: 0, text: "No"}]
    });
    $(".change2").editable({
        'source': [{value: 0, text: "Yes"}, {value: 1, text: "No"}]
    });
    $(".change3").editable({
        'source': [{value: 0, text: "Yes"}, {value: 1, text: "No"}]
    });
});