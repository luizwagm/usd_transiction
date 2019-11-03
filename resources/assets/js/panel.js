$('document').ready(function(){

	//validar senha de campos com senha
	$('body').on('blur','#resenha',function(){
		var senha = $('#senha').val();
		var resenha = $(this).val();

		if(senha == resenha){
			$('#senha, #resenha').css('border','1px solid green');
			$('#submit').attr('disabled',false);
		}else{
			$('#senha, #resenha').css('border','1px solid red');
			$('#submit').attr('disabled',true);
		}
	})

	$('.money').mask('# ##0,00', {reverse: true});

})
