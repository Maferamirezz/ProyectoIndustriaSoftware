
  CREATE OR REPLACE NONEDITIONABLE PROCEDURE "SYSTEM"."SP_REGISTRARINSUMO" (
    pcUsername in varchar2,
	--pcPassword in varchar2,
	pcNombreInsumo in varchar2,
    pdFechaCompra in date,
    pnRtnProveedor in varchar2,
    pnIdTipoInsumo in number,
    pnCantidad in number,
    pnPrecio in number,

    pnCodigo out  number,
    pcMensaje out varchar2
)
IS

	vnConteo number;
    vnIdInsumo number;
    vnIdUsuario varchar(13);
    vcTemp varchar(200);
    vError Exception;
Begin

    pnCodigo:=0;
    pcMensaje:='';
    vnConteo:=0;
	vcTemp:='';
	vnIdUsuario:=0;
    vnIdInsumo:=0;

	if pcUsername='' or pcUsername is null then
		vcTemp:='Campo requerido';
	end if;

/*	if pcPassword='' or pcPassword is null then
		vcTemp:='Campo requerido';
	end if;
*/
	if pcNombreInsumo='' or pcNombreInsumo is null then
		vcTemp:='Campo requerido';
	end if;

	if pdFechaCompra='' or pdFechaCompra is null then
		vcTemp:='Campo requerido';
	end if;

	if pnCantidad='' or pnCantidad is null then
		vcTemp:='Campo requerido';
	end if;

    if pnPrecio='' or pnPrecio is null then
		vcTemp:='Campo requerido';
	end if;

	if pnRtnProveedor='' or pnRtnProveedor is null then
		vcTemp:='Campo requerido';
	end if;

	if pnIdTipoInsumo='' or pnIdTipoInsumo is null then
		vcTemp:='Campo requerido';
	end if;
    
    --CUENTA EL USUARIO
    SELECT count(*) into vnConteo  from usuario
    where pcUsername=username; 
    
    IF(vnConteo>0) then
    --Obtiene el usaurio que realiza la accion
        SELECT idusuario into vnIdUsuario from usuario
        where pcUsername=username;
    else
     pcMensaje:='No existe el usuario.';
     Return;
    end if;
    
--Si no hay un insumo registrado con el mismo nombre
        select count(*) into vnConteo from Insumo 
        where pcNombreInsumo=nombreInsumo;    
--Entonces       
        IF vnConteo=0 then
--Contar más 1 los id de insumo, si habian 5, ahora tendra 6
                    Select count(*)+1 into vnIdInsumo from Insumo;
--Contar los insumos que tengan el mismo id  que sumamos anteriormente
                    Select count(*) into vnConteo from Insumo 
                        where idInsumo=vnIdInsumo;
 --Si hay ya un insumo registrado con ese id entonces
                    if vnConteo=1 then
                        select max(idInsumo)+1 into vnIdInsumo from Insumo;
                    end if;
		  INSERT INTO Insumo(idInsumo, nombreInsumo, fechaCompra, cantidad, precio, tipoInsumo_idTipoInsumo, usuario_idUsuario, proveedor_rtnProveedor)
		  VALUES(vnIdInsumo, pcNombreInsumo, pdFechaCompra, pnCantidad, pnPrecio, pnIdTipoInsumo, vnIdUsuario, pnRtnProveedor);
		  pnCodigo:=1;
		  pcMensaje:='Insumo registrado exitosamente mensaje desde la BD';
          Return;
         ELSE
				pnCodigo:=0;
				pcMensaje:='Error al insertar el insumo. ';
                Return;
	 END IF;
     
     Exception 
            WHEN OTHERS THEN
             pcMensaje:= pcMensaje||SQLERRM ;
             	pnCodigo:=0;
                dbms_output.put_line(pcMensaje);
END;

/
