(function($){
    $(document).ready(function(){
        var $defaultSetting = {
            formatNoMatches: devvn_array.formatNoMatches,
        };
        var loading_billing = loading_shipping = false;
        //billing
        $('#_billing_state').select2($defaultSetting);
        $('#_billing_city').select2($defaultSetting);
        $('#_billing_address_2').select2($defaultSetting);
        var city = $( "#_billing_city option:selected" ).val();
        if(city){
          $( "#_billing_city" ).data('value',city);
        }
        var address = $( "#_billing_address_2 option:selected" ).val();
        if(address){
          $( "#_billing_address_2" ).data('value',address);
        }
        var city = $( "#_shipping_city option:selected" ).val();
        if(city){
          $( "#_shipping_city" ).data('value',city);
        }
        var address = $( "#_shipping_address_2 option:selected" ).val();
        if(address){
          $( "#_shipping_address_2" ).data('value',address);
        }
        
        
        $('body').on('change select2-selecting', '#_billing_state',function(e){
            $( "#_billing_city option" ).val('');
            var matp = e.val;
            if(!matp) matp = $( "#_billing_state option:selected" ).val();
            if(matp && !loading_billing){
                loading_billing = true;
                $.ajax({
                    type : "post",
                    dataType : "json",
                    url : devvn_array.admin_ajax,
                    data : {action: "load_diagioihanhchinh", matp : matp},
                    context: this,
                    beforeSend: function(){
                        $("#_billing_city,#_billing_address_2").html('').select2();
                        var newState = new Option('Loading...', '');
                        $("#_billing_city, #_billing_address_2").append(newState);
                    },
                    success: function(response) {
                        loading_billing = false;
                        $("#_billing_city,#_billing_address_2").html('').select2();
                        var newState = new Option('Chọn xã/phường/thị trấn', '');
                        $("#_billing_address_2").append(newState);
                        if(response.success) {
                            var listQH = response.data;
                            newState = new Option('Chọn quận/huyện', '');
                            $("#_billing_city").append(newState);
                            $.each(listQH,function(index,value){
                                newState = new Option(value.name, value.maqh);
                                $("#_billing_city").append(newState);
                            });
                            if($("#_billing_city").data('value')){
                              $("#_billing_city").val($("#_billing_city").data('value')).trigger('change');
                            }
                        }
                    }
                });
            }
        });
        if($('#_billing_address_2').length > 0){
            $('#_billing_city').on('change select2-selecting',function(e){
                var maqh = e.val;
                if(!maqh) maqh = $( "#_billing_city option:selected" ).val();
                if(maqh) {
                    $.ajax({
                        type: "post",
                        dataType: "json",
                        url: devvn_array.admin_ajax,
                        data: {action: "load_diagioihanhchinh", maqh: maqh},
                        context: this,
                        beforeSend: function(){
                            $("#_billing_address_2").html('').select2();
                            var newState = new Option('Loading...', '');
                            $("#_billing_address_2").append(newState);
                        },
                        success: function (response) {
                            $("#_billing_address_2").html('').select2($defaultSetting);
                            if (response.success) {
                                var listQH = response.data;
                                var newState = new Option('Chọn xã/phường/thị trấn', '');
                                $("#_billing_address_2").append(newState);
                                $.each(listQH, function (index, value) {
                                    var newState = new Option(value.name, value.xaid);
                                    $("#_billing_address_2").append(newState);
                                });
                                if($("#_billing_address_2").data('value')){
                                  $("#_billing_address_2").val($("#_billing_address_2").data('value')).trigger('change');
                                }
                            }
                        }
                    });
                }
            });
        }
        //shipping
        $('#_shipping_state').select2($defaultSetting);
        $('#_shipping_city').select2($defaultSetting);
        $('#_shipping_address_2').select2($defaultSetting);

        $('body').on('change select2-selecting','#_shipping_state',function(e){
            $( "#_shipping_city option" ).val('');
            var matp = e.val;
            if(!matp) matp = $( "#_shipping_state option:selected" ).val();
            if(matp && !loading_shipping){
                loading_shipping = true;
                $.ajax({
                    type : "post",
                    dataType : "json",
                    url : devvn_array.admin_ajax,
                    data : {action: "load_diagioihanhchinh", matp : matp},
                    context: this,
                    beforeSend: function(){
                        $("#_shipping_city,#_shipping_address_2").html('').select2();
                        var newState = new Option('Loading...', '');
                        $("#_shipping_city, #_shipping_address_2").append(newState);
                    },
                    success: function(response) {
                        loading_shipping = false;
                        $("#_shipping_city,#_shipping_address_2").html('').select2();
                        var newState = new Option('Chọn xã/phường/thị trấn', '');
                        $("#_shipping_address_2").append(newState);
                        if(response.success) {
                            var listQH = response.data;
                            var newState = new Option('Chọn quận/huyện', '');
                            $("#_shipping_city").append(newState);
                            $.each(listQH,function(index,value){
                                var newState = new Option(value.name, value.maqh);
                                $("#_shipping_city").append(newState);
                            });
                            if($("#_shipping_city").data('value')){
                              $("#_shipping_city").val($("#_shipping_city").data('value')).trigger('change');
                            }
                        }
                    }
                });
            }
        });
        if($('#_shipping_address_2').length > 0){
            $('#_shipping_city').on('change select2-selecting',function(e){
                var maqh = e.val;
                if(!maqh) maqh = $( "#_shipping_city option:selected" ).val();
                if(maqh) {
                    $.ajax({
                        type: "post",
                        dataType: "json",
                        url: devvn_array.admin_ajax,
                        data: {action: "load_diagioihanhchinh", maqh: maqh},
                        context: this,
                        beforeSend: function(){
                            $("#_shipping_address_2").html('').select2();
                            var newState = new Option('Loading...', '');
                            $("#_shipping_address_2").append(newState);
                        },
                        success: function (response) {
                            $("#_shipping_address_2").html('').select2($defaultSetting);
                            if (response.success) {
                                var listQH = response.data;
                                var newState = new Option('Chọn xã/phường/thị trấn', '');
                                $("#_shipping_address_2").append(newState);
                                $.each(listQH, function (index, value) {
                                    var newState = new Option(value.name, value.xaid);
                                    $("#_shipping_address_2").append(newState);
                                });
                                if($("#_shipping_address_2").data('value')){
                                  $("#_shipping_address_2").val($("#_shipping_address_2").data('value')).trigger('change');
                                }
                            }
                        }
                    });
                }
            });
        }
        $(window).on('load', function(){
          if($( "#_billing_state option:selected" ).val() && $( "#_billing_city option" ).length == 1){
            $('#_billing_state').trigger('change');
          } 
          if($( "#_shipping_state option:selected" ).val() && $( "#_shipping_city option" ).length == 1){
            $('#_shipping_state').trigger('change');
          }
        });
    });
})(jQuery);