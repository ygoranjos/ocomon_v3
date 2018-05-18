$(document).ready(function(){

    $("#empresa").change(function(){
        //alert("ola");
        var empresa;
        empresa = $('#empresa').val();
        var options, index, select, option, select2;                            
        select = document.getElementById('filial'); 
        select2 = document.getElementById('departamento');
        select2.options.length = 0;                            
          

        $.ajax({
                url: './get_filiais/'+empresa,
                type: 'POST',
                dataType: "json",
                beforeSend:function(){
                    select.options.add(new Option('Aguarde..', ''));
                },
                success: function(data){
                        select.options.length = 0;
                        options = data.options;
                        for (index = 0; index < options.length; ++index) {
                            option = options[index];
                            select.options.add(new Option(option.text, option.value));
                        }
                    }
            });
        return false;
    });

    $("#filial").change(function(){
            //alert("ola");
            var filial;
            filial = $('#filial').val();
            var options, index, select, option;                            
            select = document.getElementById('departamento');                            
            

            $.ajax({
                    url: './get_departamentos/'+filial,
                    type: 'POST',
                    dataType: "json",
                    beforeSend:function(){
                        select.options.add(new Option('Aguarde..', ''));
                    },
                    success: function(data){
                            select.options.length = 0;
                            options = data.options;
                            for (index = 0; index < options.length; ++index) {
                                option = options[index];
                                select.options.add(new Option(option.text, option.value));
                            }
                        }
                });
            return false;
        });

        $("#area").change(function(){
            //alert("ola");
            var area;
            area = $('#area').val();
            var options, index, select, option, select2;                           
            select = document.getElementById('problema');    
            select2 = document.getElementById('sub-problema');
            select2.options.length = 0;                        
            

            $.ajax({
                    url: './get_problemas/'+area,
                    type: 'POST',
                    dataType: "json",
                    beforeSend:function(){
                        select.options.add(new Option('Aguarde..', ''));
                    },
                    success: function(data){  
                            select.options.length = 0;                    
                            options = data.options;
                            for (index = 0; index < options.length; ++index) {
                                option = options[index];
                                select.options.add(new Option(option.text, option.value));
                            }
                        }
                });
            return false;
        });

        $("#problema").change(function(){
            //alert("ola");
            var problema;
            problema = $('#problema').val();
            var options, index, select, option;                           
            select = document.getElementById('sub-problema');                            
            
            $.ajax({
                    url: './get_sub_problemas/'+problema,
                    type: 'POST',
                    dataType: "json",
                    beforeSend:function(){
                        select.options.add(new Option('Aguarde..', ''));
                    },
                    success: function(data){  
                            select.options.length = 0;                    
                            options = data.options;
                            for (index = 0; index < options.length; ++index) {
                                option = options[index];
                                select.options.add(new Option(option.text, option.value));
                            }
                        }
                });
            return false;
        });

        
}); 