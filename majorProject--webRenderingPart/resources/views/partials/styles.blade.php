<style type="text/css">
	*{
		margin: 0;
		box-sizing: border-box;
	}

	html,body{
		background-color: #fafafa;
	}

	header, main, footer {
		padding-left: 300px;
	}

	main{
		min-height: 85vh;
		color: #757575;
	}

	@media only screen and (max-width : 992px) {
		header, main, footer {
			padding-left: 0;
		}
	}

	li.active{
		background-color: #009688 !important;
	}

	li.active a{
		color: #fafafa !important;
	}

	li a i{
		font-size: 24px;
		color: #424242  !important;
	}

	li.active a i{
		color: #fafafa !important;
	}

	.heading{
		text-transform: uppercase;
	}

	.heading::after{
		display: block;
		content: '';
		border-bottom: 4px solid #009688;
		width: 10%;
		margin: 0px auto;
	}

	.grid {
		display: flex;
		flex-wrap: wrap;
		align-content: stretch;
		justify-content: center;
	}

	div.col.with-card{
		margin:0px !important;
		display: flex;
		align-items: stretch;
	}

	.flash-message{
		position: fixed;
		bottom: 15px;
		left: 55%;
		-webkit-transform: translate(-50%,-50%);
		transform: translate(-50%,-50%);
		display: inline-block;
		background-color: #212121;
		border: 1px solid #212121;
		border-radius: 50px;
		color: #fafafa;
		padding: 15px;
		font-size: 1.2rem;
		z-index: 10;
	}

	.blog-image {
		width: 100%;
		height: 200px; 
		-o-object-fit: cover; 
		object-fit: cover; 
		-webkit-filter: brightness(0.6); 
		filter: brightness(0.6);
	}

	.materialboxed.active{
		height: calc((100vw/16)*9) !important;
		-o-object-fit: contain !important;
		object-fit: contain !important;
	}

	@media only screen and (min-width: 1201px){
		.materialboxed.active{
			height: 90vh !important;
		}
	}

	@-webkit-keyframes fadeOut {
		0% {
			opacity: 1;
		}

		50% {
			opacity: 0.8;
		}

		80% {
			opacity: 0.2;
		}

		100% {
			opacity: 0;
		}		
	}

	@keyframes fadeOut {
		0% {
			opacity: 1;
		}

		50% {
			opacity: 0.8;
		}

		80% {
			opacity: 0.2;
		}

		100% {
			opacity: 0;
		}		
	}		

	@webkit-keyframes fadeOut {
		0% {
			opacity: 1;
		}

		50% {
			opacity: 0.8;
		}

		80% {
			opacity: 0.2;
		}

		100% {
			opacity: 0;
		}
	}

	.main{
		margin: 15px !important;
	}

	@media only screen and (max-width: 600px){
		.gallery-img{
			height: calc((((100vw)/2)/16)*9) !important; 
			-o-object-fit: cover; 
			object-fit: cover;
		}
	}

	@media only screen and (min-width: 601px) and (max-width: 992px){
		.gallery-img{
			height: calc((((100vw)/3)/16)*9) !important; 
			-o-object-fit: cover; 
			object-fit: cover;
		}
	}

	@media only screen and (min-width: 993px){
		.gallery-img{
			height: calc((((100vw - 300px)/4)/16)*9) !important; 
			-o-object-fit: cover; 
			object-fit: cover;
		}	
	}

	i.prefix{
		line-height: 1 !important;
	}

	.btn-block{
		width: 100% !important;
	}

	.invalid-feedback{
		color: red;
		padding-left: 45px;
	}
</style>