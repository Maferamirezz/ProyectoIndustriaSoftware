/* ...................................PROCEDIMIENTOS ALMACENADOS.........................................*/
--PROCEDIMIENTOS ALMACENADOS
--REGISTRAR USUARIO, EDITAR DATOS DE USUARIO

CREATE OR REPLACE PROCEDURE SP_GESTIONUSUARIO(
  pcPrimerNombre IN VARCHAR2,
  pcSegundoNombre IN VARCHAR2,
  pcPrimerApellido IN VARCHAR2,
  pcSegundoApellido IN VARCHAR2,
  pcGenero IN INTEGER,
  pcEmail IN VARCHAR2,
  pcContrasenia IN VARCHAR2,
  pcAccion IN VARCHAR2,
  pcCodigo OUT INTEGER,
  pcMessage OUT VARCHAR2)
IS
  vnConteo INTEGER;
  vnIdUsuario INTEGER;
  vnTemp VARCHAR2(500);
BEGIN
  vnConteo:=0;
  vnIdUsuario:=0;
  pcCodigo:=0;
  pcMessage:='';
  vnTemp:='';
  
  IF pcPrimerNombre='' OR pcPrimerNombre IS NULL THEN
    vnTemp:=vnTemp||' Primer nombre. ';
  END IF;
  IF pcPrimerApellido='' OR pcPrimerApellido IS NULL THEN
    vnTemp:=vnTemp||' Primer apellido. ';
  END IF;
  IF pcGenero='' OR pcGenero IS NULL THEN
    vnTemp:=vnTemp||' Genero. ';
  END IF;
  IF pcEmail='' OR pcEmail IS NULL THEN
    vnTemp:=vnTemp||' Correo electrónico. ';
  END IF;
  IF pcContrasenia='' OR pcContrasenia IS NULL THEN
    vnTemp:=vnTemp||' Contrasenia. ';
  END IF;
  IF vnTemp<>'' THEN
    pcMessage:='Campos obligatorios: '||vnTemp;
    pcCodigo:=0;
    RETURN;
  END IF;
  
  IF pcAccion='Registrar' THEN
    SELECT COUNT(*) INTO vnConteo FROM Usuario WHERE email=pcEmail;
  
    IF vnConteo=0 THEN
      SELECT COUNT(*)+1 INTO vnIdUsuario FROM USUARIO;
      SELECT COUNT(*) INTO vnConteo FROM Usuario WHERE idUsuario=vnIdUsuario;
      IF vnConteo=1 THEN
        SELECT MAX(idUsuario)+1 INTO vnIdUsuario FROM Usuario;
      END IF;
      INSERT INTO Usuario(IDUSUARIO,PRIMERNOMBRE,SEGUNDONOMBRE,PRIMERAPELLIDO,SEGUNDOAPELLIDO,IDGENERO,EMAIL,CONTRASENIA)
      VALUES(vnIdUsuario,pcPrimerNombre,pcSegundoNombre,pcPrimerApellido,pcSegundoApellido,pcGenero,pcEmail,pcContrasenia);
      pcCodigo:=1;
      pcMessage:='Usuario registrado';
      RETURN;
      ELSE
        pcCodigo:=0;
        pcMessage:='Correo electronico en uso. Por favor ingresar uno nuevo.';
        RETURN;
    END IF;
  END IF;
  
  IF pcAccion='Editar' THEN
    SELECT idUsuario INTO vnIdUsuario FROM Usuario WHERE email=pcEmail;
  
    IF vnIdUsuario<>'' OR vnIdUsuario IS NOT NULL THEN
      UPDATE USUARIO SET IDUSUARIO=vnIdUsuario,PRIMERNOMBRE=pcPrimerNombre,SEGUNDONOMBRE=pcSegundoNombre,PRIMERAPELLIDO=pcPrimerApellido,
      SEGUNDOAPELLIDO=pcSegundoApellido,IDGENERO=pcGenero,EMAIL=pcEmail,CONTRASENIA=pcContrasenia;
      pcCodigo:=1;
      pcMessage:='Usuario editado';
      RETURN;
      ELSE
        pcCodigo:=0;
        pcMessage:='Error desconocido...';
        RETURN;
    END IF;
  END IF;
END;



--PUBLICACIONES
CREATE OR REPLACE PROCEDURE SP_PUBLICACIONES_PERFIL(
                             pcIdPublicacion      IN NUMBER,
                             pcContenido          IN VARCHAR2,
                            -- pcFechaPublicacion   IN DATE,
                             pcCorreo             IN VARCHAR2,
                             pcContrasena         IN VARCHAR2,
                             pcIdTipoPost         IN NUMBER,
                             pcAccion             IN VARCHAR2,
                             pcOcurrioError       OUT BOOLEAN,
                             pcMensaje            OUT VARCHAR2)
IS 
    vnConteo            NUMBER;
    vnIdUsuario         NUMBER;
    vnIdPublicacion     NUMBER;
    vcExistencia        NUMBER;
    vcTempMensaje       VARCHAR(100);
   
BEGIN  
     vcTempMensaje:='';
     pcMensaje:='';
     pcOcurrioError:=TRUE;
     
    IF pcCorreo='' OR pcCorreo IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Correo:';
    END IF;
    IF pcContrasena='' OR pcContrasena IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Contrasena:';
    END IF;
    IF pcContenido='' OR pcContenido IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Contenido:';
    END IF;
    IF pcIdTipoPost='' OR pcIdTipoPost IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Id Tipo Post';
    END IF;
    IF pcAccion='' OR pcAccion IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Accion:';
    END IF;
    IF vcTempMensaje<>'' THEN
        pcMensaje:='Campos Requeridos'||vcTempMensaje;
        pcOcurrioError:=TRUE;
        RETURN;
    END IF;

    IF pcAccion = 'Publicar' THEN 
    SELECT  u.idUsuario INTO vcExistencia FROM Usuario u
    INNER JOIN Publicacion pub ON pub.idUsuario = u.idUsuario 
    WHERE pcCorreo IN u.email;  
     IF vcExistencia IS NOT NULL THEN 
     SELECT COUNT(idPublicacion)+1 INTO vnIdPublicacion FROM Publicacion;
     INSERT INTO Publicacion (idPublicacion, contenido, fechaPublicacion, idTipoPost, idUsuario, idPagina, idPublicidad)
              VALUES(vnIdPublicacion, pcContenido, SYSDATE, pcIdTipoPost, vcExistencia, NULL, NULL);
              RETURN;
      END IF;
    
    ELSE
    IF pcAccion = 'Eliminar' THEN
    SELECT idPublicacion INTO vcExistencia FROM Publicacion
    WHERE pcIdPublicacion IN idPublicacion;  
     IF vcExistencia IS NOT NULL THEN
     DELETE FROM Publicacion  WHERE  idPublicacion= pcIdPublicacion;
     RETURN;
     ELSE
     pcMensaje := 'Intentelo de nuevo';
     RETURN;
     END IF;
    
     ELSE
     IF pcAccion = 'Actualizar' THEN
     SELECT  u.idUsuario INTO vnIdUsuario FROM Usuario u
     INNER JOIN Publicacion pub ON pub.idUsuario = u.idUsuario 
     WHERE pcCorreo IN u.email; 
     
     SELECT idPublicacion INTO vnIdPublicacion FROM Publicacion
     WHERE pcIdPublicacion IN idPublicacion;
     IF vnIdPublicacion IS NOT NULL THEN
     UPDATE Publicacion SET idPublicacion = vnIdPublicacion, contenido = pcContenido, fechaPublicacion = SYSDATE, 
                            idTipoPost = pcIdTipoPost, idUsuario = vnIdUsuario, idPagina = NULL, idPublicidad= NULL;
                            RETURN;
     END IF;
     END IF;
     END IF;
     END IF;
     pcMensaje:='Accion realizada correctamente';
     pcOcurrioError:=FALSE;
    
END;




--COMENTARIOS DE PERFILES
CREATE OR REPLACE PROCEDURE SP_COMMENT_PERFIL(
                     pcCorreo             IN VARCHAR2,
                     pcAccion             IN VARCHAR2,
                     pcContenido          IN VARCHAR2,
                     pcIdPublicacion      IN NUMBER,
                     pcIdComentario       IN NUMBER,
                     pcMensaje            OUT VARCHAR2,
                     pcOcurrioError       OUT BOOLEAN)
IS
    vcTempMensaje       VARCHAR(100);
    vnIdComentario      NUMBER;
    vnIdUserCom         NUMBER;
    vnExistencia        NUMBER;
BEGIN 
     vcTempMensaje:='';
     pcMensaje:='';
     pcOcurrioError:=TRUE;
     
    IF pcCorreo='' OR pcCorreo IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Correo:';
    END IF;
    IF pcContenido='' OR pcContenido IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Contenido:';
    END IF;
    IF pcIdPublicacion='' OR pcIdPublicacion IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Id Publicacion:';
    END IF;
    IF pcAccion='' OR pcAccion IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Accion:';
    END IF;
    IF vcTempMensaje<>'' THEN
        pcMensaje:='Campos requeridos'||vcTempMensaje;
        pcOcurrioError:=TRUE;
        RETURN;
    END IF;
    SELECT co.idUsuario INTO vnIdUserCom FROM Usuario u
    INNER JOIN Comentarios co ON u.idUsuario = co.idUsuario
    WHERE pcCorreo IN u.email;
    
    IF pcAccion = 'Comentar' THEN
    SELECT COUNT(idComentario)+1 INTO vnIdComentario FROM Comentarios;
    
    INSERT INTO Comentarios(idComentario, contenido, fechaComentario, idTipoComment, idUsuario, idPublicacion)
                VALUES(vnIdComentario, pcContenido, SYSDATE, 4, vnIdUserCom, pcIdPublicacion);
                RETURN;
   
    ELSE 
    IF pcAccion = 'Actualizar' THEN
    IF pcIdComentario='' OR pcIdComentario IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Id Comentario:';
    END IF;

    IF vcTempMensaje<>'' THEN
        pcMensaje:='Campos requeridos'||vcTempMensaje;
        pcOcurrioError:=TRUE;
        RETURN;
    END IF;
    
    SELECT idComentario INTO vnExistencia FROM Comentarios
    WHERE pcIdComentario IN idComentario;
    IF  vnExistencia IS NOT NULL THEN 
    UPDATE Comentarios SET idComentario = vnExistencia, contenido= pcContenido, fechaComentario= SYSDATE, 
                                         idTipoComment = 4, idUsuario = vnIdUserCom, idPublicacion= pcIdPublicacion;
                                         RETURN;
    END IF;
    ELSE 
    IF pcAccion = 'Eliminar' THEN
    IF pcIdComentario='' OR pcIdComentario IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Id Comentario:';
    END IF;
    IF vcTempMensaje<>'' THEN
        pcMensaje:='Campos requeridos'||vcTempMensaje;
        pcOcurrioError:=TRUE;
        RETURN;
    END IF;
    
    SELECT idComentario INTO vnExistencia FROM Comentarios
    WHERE pcIdComentario IN idComentario;
    IF vnExistencia IS NOT NULL THEN
       DELETE FROM Comentarios WHERE pcIdComentario = idComentario;
       RETURN;
    END IF;
    END IF;
    END IF;
    END IF;
    pcMensaje:='Accion realizada correctamente';
    pcOcurrioError:=FALSE;
END;



--MENSAJES ENTRE AMIGOS
CREATE OR REPLACE PROCEDURE SP_MSJ_AMIGOS(
           pcAccion         IN VARCHAR2,
           pcContenido      IN VARCHAR2,
           pcCorreo         IN VARCHAR2,
           pcIdReceptor     IN NUMBER,
           pcIdMensaje      IN NUMBER,
           pcMensaje        OUT  VARCHAR2,
           pcOcurrioError   OUT BOOLEAN)
IS 
    vnIdReceptor       NUMBER;
    vnIdEmisor         NUMBER;
    vnIdMensaje        NUMBER;
    vnIdUsuario        NUMBER;
    vcTempMensaje      VARCHAR(100);
    vnExistencia       NUMBER;
BEGIN 
     vcTempMensaje:='';
     pcMensaje:='';
     pcOcurrioError:=TRUE;
     
    IF pcAccion='' OR pcAccion IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Accion:';
    END IF;
    IF pcCorreo='' OR pcCorreo IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Correo:';
    END IF;
    IF pcContenido='' OR pcContenido IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Contenido:';
    END IF;
    IF pcIdReceptor='' OR pcIdReceptor IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Id Receptor:';
    END IF;
    IF vcTempMensaje<>'' THEN
        pcMensaje:='Campos requeridos'||vcTempMensaje;
        pcOcurrioError:=TRUE;
        RETURN;
    END IF;

    IF pcAccion = 'Enviar' THEN
    SELECT idUsuario INTO vnIdUsuario FROM Usuario u
    WHERE pcCorreo IN email;
    
    SELECT ami.idReceptor INTO vnIdReceptor FROM Usuario u 
    INNER JOIN Amigo ami ON u.idUsuario = ami.idReceptor
    WHERE pcIdReceptor IN ami.idReceptor AND ami.estado = 'Aceptada';
    
    SELECT COUNT(idMensaje)+1 INTO vnIdMensaje FROM Mensaje;
    INSERT INTO Mensaje(idMensaje, contenido, fechaHEnvio, fechaHRecibido, idTipoMensaje, estado, idEmisor, idReceptor, idEstadoMsj)
          VALUES(vnIdMensaje, pcContenido, SYSDATE, SYSDATE, 3, 'Entregado', vnIdUsuario, vnIdReceptor, 6);
          RETURN;
    
    ELSE
    IF pcAccion = 'Responder' THEN 
    SELECT idUsuario INTO vnIdUsuario FROM Usuario 
    WHERE pcCorreo IN email;
    
    SELECT ami.idEmisor INTO vnIdEmisor FROM Usuario u 
    INNER JOIN Amigo ami ON u.idUsuario = ami.idEmisor
    WHERE pcIdReceptor IN ami.idEmisor AND ami.estado = 'Aceptada';
    
    SELECT COUNT(idMensaje)+1 INTO vnIdMensaje FROM Mensaje;
    INSERT INTO Mensaje(idMensaje, contenido, fechaHEnvio, fechaHRecibido, idTipoMensaje, estado, idEmisor, idReceptor, idEstadoMsj)
          VALUES(vnIdMensaje, pcContenido, SYSDATE, SYSDATE, 3, 'Entregado', vnIdEmisor, vnIdUsuario, 6);
          RETURN;
    
    ELSE 
    IF pcAccion = 'Eliminar' THEN 
    IF pcIdMensaje='' OR pcIdMensaje IS NULL THEN
       pcMensaje:=vcTempMensaje||'Id Mensaje:';
    END IF;
    
    SELECT idMensaje INTO vnExistencia FROM Mensaje
    WHERE pcIdMensaje IN idMensaje;
    IF vnExistencia IS NOT NULL THEN 
    
    DELETE FROM Mensaje WHERE pcIdMensaje = idMensaje;
    RETURN;
    END IF;
    END IF;
    END IF;
    END IF;
    pcMensaje:='Accion realizada correctamente';
    pcOcurrioError := FALSE;
END;


--GRUPOS
CREATE OR REPLACE PROCEDURE SP_Gestion_Grupos(
                            pcAccion              IN VARCHAR2,
                            pcIdUsuario           IN INTEGER,
                            pcDescripcion         IN VARCHAR2,
                            pcIdGrupo             IN INTEGER,
                            pcNombre              IN VARCHAR2,
                            pcMensaje             OUT  VARCHAR2,
                            pcOcurrioError        OUT BOOLEAN)

IS 
    vcTempMensaje       VARCHAR(100);
    vnExistencia        INTEGER;
    vnIdGrupo           INTEGER;
    
BEGIN 
     vcTempMensaje:='';
     pcMensaje:='';
     pcOcurrioError:=TRUE;
     
    IF pcAccion='' OR pcAccion IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Accion:';
    END IF;
    IF pcDescripcion='' OR pcDescripcion IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Descripcion:';
    END IF;
    IF pcNombre='' OR pcNombre IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Nombre:';
    END IF;
    IF vcTempMensaje<>'' THEN
        pcMensaje:='Campos requeridos'||vcTempMensaje;
        pcOcurrioError:=TRUE;
        RETURN;
    END IF; 
    
    IF pcAccion = 'Crear' THEN
    SELECT COUNT(idGrupo)+1 INTO vnIdGrupo FROM Grupos;
    
    INSERT INTO  Grupos(idGrupo, descripcion, nombre, idUsuario)
                 VALUES(vnIdGrupo, pcDescripcion, pcNombre, pcIdUsuario);
    ELSE 
    IF  pcAccion = 'Actualizar' THEN
    IF pcIdGrupo='' OR pcIdGrupo IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Id Grupo:';
    END IF;
    SELECT idGrupo INTO vnExistencia FROM Grupos
    WHERE pcIdGrupo IN idGrupo;
    IF vnExistencia IS NOT NULL THEN 
    UPDATE Grupos SET idGrupo = vnExistencia, descripcion = pcDescripcion, nombre = pcNombre, idUsuario = pcIdUsuario;
    RETURN;
    END IF;
    
    ELSE 
    IF pcAccion = 'Eliminar' THEN 
    IF pcIdGrupo='' OR pcIdGrupo IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Id Grupo:';
    END IF;
    SELECT idGrupo INTO vnExistencia FROM Grupos
    WHERE pcIdGrupo IN idGrupo;
    
    DELETE FROM Grupos WHERE pcIdGrupo = idGrupo;
    RETURN;
    END IF;
    END IF;
    
    END IF;
    pcMensaje:='Accion realizada correctamente';
    pcOcurrioError := FALSE;
    
END;



--GRUPO USUARIOS
CREATE OR REPLACE PROCEDURE SP_Gestion_User_Grupos(
                            pcAccion              IN VARCHAR2,
                            pcIdUsuario           IN INTEGER,
                            pcIdGrupo             IN INTEGER,
                            pcMensaje             OUT  VARCHAR2,
                            pcOcurrioError        OUT BOOLEAN)
IS 
    vcTempMensaje       VARCHAR(100);
    vnExistencia        INTEGER;
BEGIN 
     vcTempMensaje:='';
     pcMensaje:='';
     pcOcurrioError:=TRUE;
     
    IF pcAccion='' OR pcAccion IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Accion:';
    END IF;
    IF pcIdGrupo='' OR pcIdGrupo IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Id Grupo:';
    END IF;
    IF pcIdUsuario='' OR pcIdUsuario IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Id Usuario:';
    END IF;
    IF vcTempMensaje<>'' THEN
        pcMensaje:='Campos requeridos'||vcTempMensaje;
        pcOcurrioError:=TRUE;
        RETURN;
    END IF; 
    
    SELECT idGrupo  INTO vnExistencia FROM Grupos
    WHERE pcIdGrupo IN idGrupo;
    
    IF pcAccion = 'Unir' THEN
    IF vnExistencia IS NOT NULL THEN
    INSERT INTO  Grupo_Usuario(idGrupo, idUsuario, fechaIngreso)
                 VALUES(vnExistencia, pcIdUsuario, SYSDATE);
                 RETURN;
    END IF;
    ELSE 
    IF  pcAccion = 'Salir' THEN
    IF vnExistencia IS NOT NULL THEN 
    DELETE FROM Grupos WHERE pcIdGrupo = idGrupo;
    RETURN;
    END IF;
    END IF;
    
    END IF;
    pcMensaje:='Accion realizada correctamente';
    pcOcurrioError := FALSE;   
END;



--GESTION PAGINA 
CREATE OR REPLACE PROCEDURE SP_GESTION_PAGINA (
                    pcAccion             IN VARCHAR2,
                    pcIdUsuario          IN INTEGER,
                    pcFechaInicio        IN DATE,
                    pcIdPagina           IN INTEGER,
                    pcIdAdministrador    IN INTEGER,
                    pcDescripcion        IN VARCHAR2,
                    pcCategoria          IN VARCHAR2,
                    pcNombrePag          IN VARCHAR2,
                    pcUbicacion          IN VARCHAR2,
                    pcTelefono           IN VARCHAR2,
                    pcIdTipoPagina       IN INTEGER,
                    pcTipoContenido      IN  VARCHAR2,
                    pcMensaje            OUT VARCHAR2,
                    pcOcurrioError       OUT  BOOLEAN)
IS
   vcTempMensaje    	  VARCHAR2(500);
   vnIdTipoPagina       INTEGER;
   vnIdPagina           INTEGER;
   vnIdAdPagina         INTEGER;
BEGIN
    vcTempMensaje:='';
    pcMensaje:='';
    pcOcurrioError:=TRUE;
    
    IF pcAccion = '' OR pcAccion IS NULL THEN 
        vcTempMensaje:=vcTempMensaje||'Accion:';
    END IF;
    
    IF pcAccion = 'Registrar' THEN 
    
    IF pcCategoria='' OR pcCategoria IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Id Categoria:';
    END IF;
    IF pcTipoContenido='' OR pcTipoContenido IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Tipo Contenido';
    END IF;
    IF pcNombrePag='' OR pcNombrePag IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Nombre Pagina';
    END IF;
    IF pcDescripcion='' OR pcDescripcion IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Descripcion';
    END IF;
    
    IF vcTempMensaje<>'' THEN
        pcMensaje:='Campos requeridos'||vcTempMensaje;
        pcOcurrioError:=TRUE;
        RETURN;
    END IF; 
    SELECT COUNT(idTipoPagina)+1 INTO vnIdTipoPagina FROM TipoPagina;
    INSERT INTO TipoPagina (idTipoPagina, categoria, tipoContenido)
                VALUES(vnIdTipoPagina, pcCategoria, pcTipoContenido);
    
    SELECT COUNT(idPagina)+1 INTO vnIdPagina FROM Pagina;
    INSERT INTO Pagina(idPagina, nombrePagina, descripcion, ubicacion, telefono, idTipoPagina)
                 VALUES(vnIdPagina, pcNombrePag, pcDescripcion, pcUbicacion, pcTelefono, vnIdTipoPagina);
                 
    SELECT COUNT(idAdPagina)+1 INTO vnIdAdPagina FROM AdministradorPag;
    INSERT INTO AdministradorPag (idAdPagina, fechaInicio, idUsuario, idPagina)
                          VALUES(vnIdAdPagina, pcFechaInicio, pcIdUsuario, vnIdPagina);
                          RETURN;
    ELSE
    IF pcAccion = 'Actualizar' OR pcAccion = 'Eliminar' THEN 
    IF pcIdPagina='' OR pcIdPagina IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Id Pagina';
    END IF;
    IF pcIdAdministrador='' OR pcIdAdministrador IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Id Adminsitrador';
    END IF;
    IF pcCategoria='' OR pcCategoria IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Id Categoria:';
    END IF;
    IF pcTipoContenido='' OR pcTipoContenido IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Tipo Contenido';
    END IF;
    IF pcNombrePag='' OR pcNombrePag IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Nombre Pagina';
    END IF;
    IF pcDescripcion='' OR pcDescripcion IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Descripcion';
    END IF;
    
    IF vcTempMensaje<>'' THEN
        pcMensaje:='Campos requeridos'||vcTempMensaje;
        pcOcurrioError:=TRUE;
        RETURN;
    END IF; 
    IF pcAccion = 'Actualizar' THEN
    UPDATE TipoPagina  SET idTipoPagina = pcIdTipoPagina, categoria = pcCategoria, tipoContenido= pcTipoContenido;
               
    UPDATE Pagina SET idPagina = pcIdPagina, nombrePagina = pcNombrePag, descripcion=pcDescripcion, ubicacion = pcUbicacion, telefono= pcTelefono, idTipoPagina= pcIdTipoPagina;
                
    UPDATE AdministradorPag SET idAdPagina = pcIdAdministrador, fechaInicio = pcFechaInicio, idUsuario = pcIdUsuario, idPagina = pcIdPagina;
                          RETURN;
    ELSE 
    IF pcAccion = 'Eliminar' THEN
    DELETE FROM TipoPagina WHERE idTipoPagina = pcIdTipoPagina;
    
    DELETE FROM Pagina WHERE idPagina = pcIdPagina;
    
    DELETE FROM AdministradorPag WHERE idAdPagina = pcIdAdministrador;
    RETURN;
    END IF;
    END IF;
    END IF;
    END IF;
    
    pcMensaje:='Accion realizada correctamente';
    pcOcurrioError:=FALSE;
END;


--PUBLICACIONES PAGINA
CREATE OR REPLACE PROCEDURE SP_PUBLICACIONES_PAGINA(
                             pcIdPublicacion      IN INTEGER,
                             pcContenido          IN VARCHAR2,
                             pcCorreo             IN VARCHAR2,
                             pcIdTipoPost         IN INTEGER,
                             pcIdPublicidad       IN INTEGER,
                             pcAccion             IN VARCHAR2,
                             pcOcurrioError       OUT BOOLEAN,
                             pcMensaje            OUT VARCHAR2)
IS 
    vnIdPublicacion     INTEGER;
    vnIdPagina          INTEGER;
    vcExistencia        INTEGER;
    vnIdAdministrador   INTEGER;
    vcTempMensaje       VARCHAR(100);
   
BEGIN  
     vcTempMensaje:='';
     pcMensaje:='';
     pcOcurrioError:=TRUE;
     
    IF pcCorreo='' OR pcCorreo IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Correo:';
    END IF;
    IF pcContenido='' OR pcContenido IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Contenido:';
    END IF;
    IF pcIdTipoPost='' OR pcIdTipoPost IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Id Tipo Post';
    END IF;
    IF pcAccion='' OR pcAccion IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Accion:';

    IF vcTempMensaje<>'' THEN
        pcMensaje:='Campos Requeridos'||vcTempMensaje;
        pcOcurrioError:=TRUE;
        RETURN;
    END IF;

    IF pcAccion = 'Publicar' THEN 
    SELECT  u.idUsuario INTO vcExistencia FROM Usuario u
    INNER JOIN Publicacion pub ON pub.idUsuario = u.idUsuario 
    WHERE pcCorreo IN u.email; 
    
    SELECT adp.idUsuario, adp.idPagina INTO vnIdAdministrador, vnIdPagina FROM Pagina pag
    INNER JOIN AdministradorPag adp ON pag.idPagina = adp.idPagina
    INNER JOIN Usuario u ON adp.idUsuario = u.idUsuario
    WHERE vcExistencia IN adp.idUsuario;
    
    IF vnIdAdministrador IS NOT NULL THEN 
    
     SELECT COUNT(idPublicacion)+1 INTO vnIdPublicacion FROM Publicacion;
     INSERT INTO Publicacion (idPublicacion, contenido, fechaPublicacion, idTipoPost, idUsuario, idPagina, idPublicidad)
              VALUES(vnIdPublicacion, pcContenido, SYSDATE, pcIdTipoPost,vnIdAdministrador , vnIdPagina,  pcIdPublicidad);
              RETURN;
    END IF;
    
    ELSE
    IF pcAccion = 'Eliminar' THEN
    SELECT idPublicacion INTO vcExistencia FROM Publicacion
    WHERE pcIdPublicacion IN idPublicacion;  
     IF vcExistencia IS NOT NULL THEN
     DELETE FROM Publicacion  WHERE  idPublicacion= pcIdPublicacion;
     RETURN;
     ELSE
     pcMensaje := 'Intentelo de nuevo';
     RETURN;
     END IF;
    
     ELSE
     IF pcAccion = 'Actualizar' THEN
    SELECT  u.idUsuario INTO vcExistencia FROM Usuario u
    INNER JOIN Publicacion pub ON pub.idUsuario = u.idUsuario 
    WHERE pcCorreo IN u.email; 
    
    SELECT adp.idUsuario, adp.idPagina INTO vnIdAdministrador, vnIdPagina FROM Pagina pag
    INNER JOIN AdministradorPag adp ON pag.idPagina = adp.idPagina
    INNER JOIN Usuario u ON adp.idUsuario = u.idUsuario
    WHERE vcExistencia IN adp.idUsuario;
    
     SELECT idPublicacion INTO vnIdPublicacion FROM Publicacion
     WHERE pcIdPublicacion IN idPublicacion;
     IF vnIdPublicacion IS NOT NULL THEN
     UPDATE Publicacion SET idPublicacion = vnIdPublicacion, contenido = pcContenido, fechaPublicacion = SYSDATE, 
                            idTipoPost = pcIdTipoPost, idUsuario = vnIdAdministrador, idPagina = vnIdPagina, idPublicidad= pcIdPublicidad;
                            RETURN;
     END IF;
     END IF;
     END IF;
     END IF;
    END IF;
      pcMensaje:='Accion realizada correctamente';
      pcOcurrioError:=FALSE;
  
END;

CREATE OR REPLACE PROCEDURE SP_GESTION_PERFIL (
                    pcAccion             IN VARCHAR2,
                    pcCorreo             IN VARCHAR2,
                    pcContrasenia        IN VARCHAR2,
                    pcFoto               IN VARCHAR2,
                    pcGenero             IN NUMBER,
                    pcFechaNac           IN DATE,
                    pcReligion           IN VARCHAR2,
                    pcPolitica           IN VARCHAR2,
                    pcEstadoCivil        IN NUMBER,
                    pcApodo              IN VARCHAR2,
                    pcTelefono           IN VARCHAR2,
                    pcLugarNac           IN NUMBER,
                    pcLugarResidencia    IN NUMBER,
                    pcInstitucion        IN VARCHAR2,
                    pcTitulo             IN VARCHAR2,
                    pcSitioWeb           IN VARCHAR2,
                    pcNombreEmpleo       IN VARCHAR2,
                    pcCargo              IN VARCHAR2,
                    pcFechaInicio        IN DATE,
                    pcFechaFin           IN DATE,
                    pcIdioma             IN NUMBER,
                    pcDescripcion        IN VARCHAR2,
                    pcNivel              IN VARCHAR2,
                    pcCategoria          IN NUMBER,
                    pcInteres            IN VARCHAR2,
                    pcMensaje            OUT VARCHAR2,
                    pcOcurrioError       OUT  BOOLEAN)
IS
   vnIdPerfil           NUMBER;
   vnIdUsuario          NUMBER;
   vnIdInteres          NUMBER;
   vnDireccion          VARCHAR2(700);
   vnIdTrabajoPerfil    NUMBER;
   vnIdTrabajo          NUMBER;
   vnIdInstitucionPerf  NUMBER;
   vnIdTipoInteres      NUMBER;
   vnIdIdiomaUser       NUMBER;
   vnIdCargo            NUMBER;
   vnCategoria          VARCHAR2(500);
   vnIdInteresUser      NUMBER;
   vcExistencia         VARCHAR2(400);
   vnIdInstitucion      NUMBER;
   vcTempMensaje    	  VARCHAR2(500);
BEGIN
    vcTempMensaje:='';
    pcMensaje:='';
    pcOcurrioError:=TRUE;
    
    IF pcCorreo='' OR pcCorreo IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Correo:';
    END IF;
    IF pcContrasenia='' OR pcContrasenia IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Contrasena';
    END IF;
    IF pcAccion = '' OR pcAccion IS NULL THEN 
        vcTempMensaje:=vcTempMensaje||'Accion:';
    END IF;
    IF vcTempMensaje<>'' THEN
        pcMensaje:='Campos requeridos'||vcTempMensaje;
        pcOcurrioError:=TRUE;
        RETURN;
    END IF;
    
    IF pcAccion= 'Editar' OR pcAccion = 'Actualizar' THEN
	  IF pcGenero='' OR pcGenero IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Genero';
    END IF;
	  IF pcFechaNac='' OR pcFechaNac IS NULL  THEN
        vcTempMensaje:=vcTempMensaje||' Fecha de Nacimiento ';
    END IF;
       
    IF pcInstitucion='' OR pcInstitucion IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Institucion:';
    END IF;
    IF pcTitulo='' OR pcTitulo IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Titulo';
    END IF;
	  IF pcNombreEmpleo='' OR pcNombreEmpleo IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Nombre Empleo';
    END IF;
    IF pcCargo='' OR pcCargo IS NULL THEN
      vcTempMensaje:=vcTempMensaje||'Cargo';
    END IF;
	  IF pcIdioma='' OR pcIdioma IS NULL  THEN
        vcTempMensaje:=vcTempMensaje||' Idioma ';
    END IF;
    IF pcCategoria='' OR pcCategoria IS NULL THEN
        vcTempMensaje:=vcTempMensaje||'Categoria';
    END IF;
	  IF pcInteres='' OR pcInteres IS NULL  THEN
        vcTempMensaje:=vcTempMensaje||' Interes ';
    END IF;
    IF vcTempMensaje<>'' THEN
        pcMensaje:='Campos requeridos'||vcTempMensaje;
        pcOcurrioError:=TRUE;
    END IF;
    END IF;
    
    IF pcAccion= 'Editar' THEN
    SELECT idUsuario INTO vnIdUsuario FROM Usuario
    WHERE pcCorreo IN email;
    
    SELECT email INTO vcExistencia FROM Usuario
    WHERE pcCorreo IN email; 
    IF vcExistencia IS NOT NULL THEN
      SELECT COUNT(idPerfil)+1 INTO vnIdPerfil FROM Perfil;
      INSERT INTO Perfil(idPerfil, foto, fechaNacimiento, religion, politica, estadoCivil, apodo, telefono, sitioWeb, fechaCreacion, idLugarResidencia, idLugarNac, idUsuario, descripcion)
                  VALUES(vnIdPerfil, pcFoto, pcFechaNac, pcReligion, pcPolitica, pcEstadoCivil, pcApodo, pcTelefono, pcSitioWeb, SYSDATE, pcLugarResidencia, pcLugarNac,vnIdUsuario , pcDescripcion);
              
      SELECT ie.idInstitucion, ie.direccion INTO vnIdInstitucion, vnDireccion FROM Institucion_Educativa ie
      INNER JOIN Institucion_Perfil ip ON ie.idInstitucion = ip.idInstitucion
      WHERE pcInstitucion IN ie.nombre;
      INSERT INTO Institucion_Educativa(idInstitucion, nombre, direccion)
                  VALUES(vnIdInstitucion, pcInstitucion, vnDireccion);
      
      SELECT COUNT(idInstitucionPerfil)+1 INTO vnIdInstitucionPerf FROM Institucion_Perfil;
      INSERT INTO Institucion_Perfil(idInstitucionPerfil, fechaInicio, fechaFin, tituloObtenido, idPerfil, idInstitucion )
                              VALUES(vnIdInstitucionPerf, pcFechaInicio, pcFechaFin, pcTitulo, vnIdPerfil, vnIdInstitucion);
                  
      SELECT idUsuario INTO vnIdUsuario FROM Usuario
      WHERE pcCorreo IN email;
      
      SELECT iu.idIdiomaUser INTO vnIdIdiomaUser FROM Usuario u
      INNER JOIN Idioma_Usuario iu ON u.idUsuario = iu.idUsuario
      INNER JOIN Perfil pe ON u.idUsuario = pe.idUsuario
      WHERE vnIdUsuario IN pe.idPerfil;
      
      INSERT INTO Idioma_Usuario (idIdiomaUser, nivel, idIdioma, idUsuario)
                     VALUES(vnIdIdiomaUser, pcNivel, pcIdioma, vnIdUsuario);
                     
     /* SELECT tp. INTO FROM Trabajo_Perfil tp
      INNER JOIN Trabajo tr ON tp.idTrabajo = tr.idTrabajo
      INNER JOIN Cargo ca ON tp.idCargo = ca.idCargo
      INNER JOIN Perfil pe ON tp.idPerfil = pe.idPerfil
      WHERE vnIdPerfil IN tp.idPerfil;*/
      
      SELECT idTrabajo, categoria INTO vnIdTrabajo, vnCategoria FROM Trabajo
      WHERE pcNombreEmpleo IN nombreEmpresa;
      
      SELECT idCargo INTO vnIdCargo FROM Cargo 
      WHERE pcCargo IN descripcion;
      
      SELECT COUNT(idTrabajoPerfil)+1 INTO vnIdTrabajoPerfil FROM Trabajo_Perfil
      WHERE vnIdTrabajo IN idTrabajo AND vnIdCargo IN idCargo;
      INSERT INTO Trabajo_Perfil(idTrabajoPerfil, fechaInicio, fechaFin, idPerfil, idTrabajo, idCargo)
             VALUES(vnIdTrabajoPerfil, pcFechaInicio, pcFechaFin, vnIdPerfil, vnIdTrabajo, vnIdCargo);
      
      SELECT ti.idTipoInteres, inte.idInteres INTO vnIdTipoInteres, vnIdInteres FROM Usuario u
      INNER JOIN Perfil pe ON u.idUsuario = pe.idUsuario
      INNER JOIN Interes_Usuario iu ON u.idUsuario = iu.idUsuario
      INNER JOIN Intereses inte ON iu.idInteres = inte.idInteres
      INNER JOIN TipoInteres ti ON inte.idTipoInteres = ti.idTipoInteres
      WHERE pcCategoria IN ti.descripcion AND pcInteres IN inte.nombre;
      
      SELECT COUNT(idInteresUser)+1 INTO vnIdInteresUser FROM Interes_Usuario;
      
      INSERT INTO Interes_Usuario (idInteresUser, gradoInteres, idUsuario, idInteres)
                     VALUES(vnIdInteresUser, NULL, vnIdUsuario, vnIdInteres);

    END IF;
   
    ELSE
    IF pcAccion = 'Actualizar' THEN
    SELECT idUsuario INTO vnIdUsuario FROM Usuario
    WHERE pcCorreo IN email;
    
    SELECT email INTO vcExistencia FROM Usuario
    WHERE pcCorreo IN email; 
    IF vcExistencia IS NOT NULL THEN
      SELECT COUNT(idPerfil)+1 INTO vnIdPerfil FROM Perfil;
      UPDATE Perfil SET idPerfil = vnIdPerfil, foto = pcFoto, fechaNacimiento = pcFechaNac, religion =pcReligion, 
                        politica=pcPolitica, estadoCivil= pcEstadoCivil, apodo = pcApodo, telefono = pcTelefono, 
                        sitioWeb = pcSitioWeb, fechaCreacion = SYSDATE, idLugarResidencia = pcLugarResidencia, 
                        idLugarNac= pcLugarNac, idUsuario = vnIdUsuario, descripcion = pcDescripcion;
      
      --REVISAR
      SELECT ie.idInstitucion, ie.direccion INTO vnIdInstitucion, vnDireccion FROM Institucion_Educativa ie
      INNER JOIN Institucion_Perfil ip ON ie.idInstitucion = ip.idInstitucion
      WHERE pcInstitucion IN ie.nombre;
      UPDATE  Institucion_Educativa SET idInstitucion = vnIdInstitucion, nombre = pcInstitucion, direccion = vnDireccion;
      
        SELECT COUNT(idInstitucionPerfil)+1 INTO vnIdInstitucionPerf FROM Institucion_Perfil;
      INSERT INTO Institucion_Perfil(idInstitucionPerfil, fechaInicio, fechaFin, tituloObtenido, idPerfil, idInstitucion )
                              VALUES(vnIdInstitucionPerf, pcFechaInicio, pcFechaFin, pcTitulo, vnIdPerfil, vnIdInstitucion);
      
      SELECT idUsuario INTO vnIdUsuario FROM Usuario
      WHERE pcCorreo IN email;
                            
      SELECT iu.idIdiomaUser INTO vnIdIdiomaUser FROM Usuario u
      INNER JOIN Idioma_Usuario iu ON u.idUsuario = iu.idUsuario
      INNER JOIN Perfil pe ON u.idUsuario = pe.idUsuario
      WHERE vnIdUsuario IN pe.idPerfil;
      UPDATE Idioma_Usuario SET idIdiomaUser = vnIdIdiomaUser, nivel=pcNivel, idIdioma=pcIdioma, idUsuario=vnIdUsuario;
  
      
      SELECT idTrabajo, categoria INTO vnIdTrabajo, vnCategoria FROM Trabajo
      WHERE pcNombreEmpleo IN nombreEmpresa;
      
      SELECT idCargo INTO vnIdCargo FROM Cargo 
      WHERE pcCargo IN descripcion;
      
      SELECT COUNT(idTrabajoPerfil)+1 INTO vnIdTrabajoPerfil FROM Trabajo_Perfil
      WHERE vnIdTrabajo IN idTrabajo AND vnIdCargo IN idCargo;
      
      UPDATE Trabajo_Perfil SET idTrabajoPerfil = vnIdTrabajoPerfil, fechaInicio=pcFechaInicio, fechaFin=pcFechaFin,
                                    idPerfil=vnIdPerfil, idTrabajo = vnIdTrabajo, idCargo=vnIdCargo;
  
      
      SELECT ti.idTipoInteres, inte.idInteres INTO vnIdTipoInteres, vnIdInteres FROM Usuario u
      INNER JOIN Perfil pe ON u.idUsuario = pe.idUsuario
      INNER JOIN Interes_Usuario iu ON u.idUsuario = iu.idUsuario
      INNER JOIN Intereses inte ON iu.idInteres = inte.idInteres
      INNER JOIN TipoInteres ti ON inte.idTipoInteres = ti.idTipoInteres
      WHERE pcCategoria IN ti.descripcion AND pcInteres IN inte.nombre;
      
      SELECT COUNT(idInteresUser)+1 INTO vnIdInteresUser FROM Interes_Usuario;
      
      UPDATE Interes_Usuario SET idInteresUser = vnIdInteresUser, gradoInteres = NULL, idUsuario = vnIdUsuario, idInteres=vnIdInteres;
      RETURN;
    END IF;
    END IF;
    
    END IF;
    pcMensaje:='Accion realizada correctamente';
    pcOcurrioError:=FALSE;
END;
