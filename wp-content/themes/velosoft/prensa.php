<?php

  require("functions.php");

  get_header();
?>

<body>


			<!-- Inicia blog -->
			<div class="row">
				<div class="col l12 m12 s12 historial" style="margin-top:50px;">
					<div class="col l6">
						<img src="images/historial-prensa/1.png" alt="">
					</div>
					<div class="col l6">
						<div class="col l12">
							<div class="col l12 historial-title">
								<p>
									LECCIONES DE VIDA QUE ME DEJÓ EL MARATÓN DE CHICAGO
								</p>
							</div>
							<div class="col l6 m6 s6 text-subtitle">
								<p>
									ENTREPRENEUR
								</p>
							</div>
							<div class="col l6 m6 s6 text-subtitle center nopadding">
								<p>
									11 de cotubre del 2016
								</p>
							</div>
							<div class="col l12 m12 s12 text-historial">
								<p>
									Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras mattis orci et turpis ultrices volutpat. Mauris tri ex blandit elit, sed fermentum velit nisi id lorem...
								</p>
							</div>
							<div class="col l6 m6 s6 text-compartir">
								<p><i class="fa fa-share-alt" aria-hidden="true"></i>compartir</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col l12 m12 s12 historial" style="margin-top:20px;">
					<div class="col l6">
						<img src="images/historial-prensa/2.png" alt="">
					</div>
					<div class="col l6">
						<div class="col l12">
							<div class="col l12 historial-title">
								<p>
									COMO SUPERÉ EL MIEDO A SER MI PROPIO PATRÓN
								</p>
							</div>
							<div class="col l6 m6 s6 text-subtitle">
								<p>
									ENTREPRENEUR
								</p>
							</div>
							<div class="col l6 m6 s6 text-subtitle center nopadding">
								<p>
									28 de septiembre del 2016
								</p>
							</div>
							<div class="col l12 m12 s12 text-historial">
								<p>
									Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras mattis orci et turpis ultrices volutpat. Mauris tri ex blandit elit, sed fermentum velit nisi id lorem...
								</p>
							</div>
							<div class="col l6 m6 s6 text-compartir">
								<p><i class="fa fa-share-alt" aria-hidden="true"></i>compartir</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col l12 m12 s12 historial" style="margin-top:20px;">
					<div class="col l6">
						<img src="images/historial-prensa/3.png" alt="">
					</div>
					<div class="col l6">
						<div class="col l12">
							<div class="col l12 m12 s12 historial-title">
								<p>
									¿TIENES MADERA PARA CONVERTIRTE EN UN EMPRENDEDOR?
								</p>
							</div>
							<div class="col l6 m6 s6 text-subtitle">
								<p>
									STARTUPS
								</p>
							</div>
							<div class="col l6 m6 s6 text-subtitle center nopadding">
								<p>
									01 de enero del 2016
								</p>
							</div>
							<div class="col l12 m12 s12 text-historial">
								<p>
									Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras mattis orci et turpis ultrices volutpat. Mauris tri ex blandit elit, sed fermentum velit nisi id lorem...
								</p>
							</div>
							<div class="col l6 m6 s6 text-compartir">
								<p><i class="fa fa-share-alt" aria-hidden="true"></i>compartir</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Fin Blog -->
			<!-- Botones -->
			<div class="row">
				<div class="col l4 offset-l4 m6 offset-m3 s12 articulos">
					<div class="col l12 m12 s12 center">
						<p>
							<i class="material-icons">keyboard_backspace</i> Más articulos <i class="material-icons">arrow_forward</i>
						</p>
					</div>
				</div>
			</div>
			<!-- Fin Botones -->
      <!-- Inicio Contacto -->
      <div class="row nomargin" style="border-bottom: 2px solid #fff;">
        <div class="col l12 bg-historial">
          <div class="col s12 m12 l12 center text-contacto">
            <p>CO<span>NTAC</span>TO</p>
          </div>
          <div class="col l8 offset-l2 m12 s12 margin-100">
            <div class="col l12 m12 s12">
              <div class="col l3 m3 s12 correo-text">
                <p style="margin: 8px 0;">Nombre</p>
              </div>
              <div class="col l9 m9 s12">
                <input class="campos-input" id="nombre" type="text" class="validate">
              </div>
            </div>
            <div class="col l12 m12 s12">
              <div class="col l3 m3 s12 correo-text">
                <p style="margin: 8px 0;">Correo electrónico</p>
              </div>
              <div class="col l9 m9 s12">
                <input class="campos-input" id="correo" type="text" class="validate">
              </div>
            </div>
            <div class="col l12 m12 s12">
              <div class="col col l3 m3 s12 correo-text">
                <p style="margin: 0px 0;">Comentario</p>
              </div>
              <div class="col l9 m9 s12">
                <textarea id="textarea" class="materialize-textarea comentarios-historial"></textarea>
              </div>
            </div>
            <div class="col l12 m12 s12 right-align margin-30 bothom-30" style="margin-top: 15px;">
              <input type="button " class="btn boton-contacto" value="Enviar" readonly="readonly">
            </div>
          </div>
        </div>
      </div>
      <!-- Fin Contacto -->
      <footer>
        <div class="row nomargin footer">
          <div class="col l12 m12 s12 center text-footer">
            <p><i class="fa fa-registered" aria-hidden="true"></i>Todos los derechos reservados</p>
          </div>
        </div>
      </footer>



<?php
  get_footer();
?>
