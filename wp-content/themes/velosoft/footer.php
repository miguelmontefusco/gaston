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
    </footer>
    <?php wp_footer(); ?>
  </body>
</html>