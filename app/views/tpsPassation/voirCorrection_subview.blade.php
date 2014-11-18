<?php $i = $premiereQuestion; ?>




@foreach($questions as $question)
		<div class='col-sm-2'><strong>{{$i . ") ".$reponses[$question->id]->note. ' / '.$question->pivot->sur_local}}</strong></div>	
		<div class='col-sm-10'><strong>{{$question->nom}}</strong></div> 		
		<div class = 'col-sm-12'>
			<div class="resizeDiv">{{$question->enonce}}</div>
		</div>
		<div class='col-sm-12'><strong>Bonne réponse</strong></div>
		<div class = 'col-sm-12'>
			<div class="resizeDiv" ">{{$question->reponse?:"."}}</div>
		</div>
		<div class='col-sm-12'><strong>Ta réponse</strong></div>
		<div class = 'col-sm-12'>
			<div class="resizeDiv" ">{{$reponses[$question->id]->reponse?:"Aucune réponse soumise"}}</div>
		</div>
		<div class='col-sm-12'><strong>Commentaires de correction</strong></div>
		<div class = 'col-sm-12'>
			<div class="resizeDiv" ">{{$reponses[$question->id]->commentaire?:"."}}</div>
		</div>
		<div class ='col-sm-12' style="background-color: black; height: 5px;"></div>
<?php $i++; ?>
@endforeach

