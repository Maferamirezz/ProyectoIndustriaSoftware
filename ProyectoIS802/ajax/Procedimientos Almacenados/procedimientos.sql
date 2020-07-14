------------------USUARIO SP CON SUS RESPECTIVAS PRUEBAS-------------------
create or replace procedure SP_RegistrarUsuario(
    pcIdUsuario in varchar2,
	pcPrimerNombre in varchar2,
	pcSegundoNombre in varchar2,
	pcPrimerApellido in varchar2,
	pcSegundoApellido in varchar2,
	pnIdGenero in integer,
	pnTelefono in integer,
	pnIdAreaTrabajo in integer,
    pnContrato in integer,
	pcUsername in varchar2,
	pcPassword1 in varchar2,
	pcPassword2 in varchar2,
    pnIdTipoUsuario in integer,
    pcDireccion in varchar2,

    pnCodigo out integer,
    pcMensaje out varchar2
)

IS

	 vnConteo integer;
     vcTemp varchar2(200);
    
Begin

    pnCodigo:=0;
    pcMensaje:='';
    vnConteo:=0;
	vcTemp:='';

	if pcIdUsuario='' or pcIdUsuario is null then
		vcTemp:='Campo requerido';
    end if;

	if pcPrimerNombre='' or pcPrimerNombre is null then
		vcTemp:='Campo requerido';
    end if;

	if pcSegundoNombre='' or pcSegundoNombre is null then
		vcTemp:='Campo requerido';
    end if;

	if pcPrimerApellido='' or pcPrimerApellido is null then
		vcTemp:='Campo requerido';
    end if;

	if pcSegundoApellido='' or pcSegundoApellido is null then
		vcTemp:='Campo requerido';
    end if;  

	if pnIdGenero='' or pnIdGenero is null then
		vcTemp:='Campo requerido';
    end if;  

	if pnTelefono='' or pnTelefono is null then
		vcTemp:='Campo requerido';
    end if;
    
	if pnIdAreaTrabajo='' or pnIdAreaTrabajo is null then
		vcTemp:='Campo requerido';
	end if;
    
    if pnContrato='' or pnContrato is null then
		vcTemp:='Campo requerido';
	end if;
    
	if pcUsername='' or  pcUsername is null then
		vcTemp:='Campo requerido';
    end if;

	if pcPassword1='' or pcPassword1 is null then
		vcTemp:='Campo requerido';
	end if;
	
	if pcPassword2='' or pcPassword2 is null then
		vcTemp:='Campo requerido';
	end if;

	if pnIdTipoUsuario='' or pnIdTipoUsuario is null then
		vcTemp:='Campo requerido';
	end if;
    
    if pcDireccion='' or pcDireccion is null then
		vcTemp:='Campo requerido';
    end if;

		SELECT COUNT(*) INTO vnConteo FROM Usuario WHERE idUsuario=pcIdUsuario;
 
		IF vnConteo=0 then
          INSERT INTO Persona(idPersona, pNombre, sNombre, pApellido, sApellido, telefono, direccion, genero_idgenero)
          VALUES(pcIdUsuario, pcPrimerNombre, pcSegundoNombre, pcPrimerApellido, pcSegundoApellido, pnTelefono, pcDireccion, pnIdGenero);
		  INSERT INTO Usuario(idUsuario, username, contrasenia, contrato, estado,tipousuario_idtipousuario, areatrabajo_idareatrabajo, persona_idpersona)
		  VALUES(pcIdUsuario, pcUsername, pcPassword1, pnContrato, '1', pnIdTipoUsuario, pnIdAreaTrabajo, pcidusuario);
            pnCodigo:=1;
            pcMensaje:='Usuario registrado exitosamente.';
            DBMS_OUTPUT.PUT_LINE(pnCodigo || pcMensaje);
            Return;
		  ELSE
			pnCodigo:=0;
			pcMensaje:='Código de usuario en uso. Por favor ingresar uno nuevo.';
            DBMS_OUTPUT.PUT_LINE(pnCodigo || pcMensaje);
            Return;
		END IF;

END;

set SERVEROUTPUT ON;

Declare
    pnCodigo12 number;
    pcMensaje12 varchar2(200);
Begin
    SP_RegistrarUsuario('080119991168','Maria', 'Fernanda', 'Ramirez', 'Maldonado', '2', '33606018', '1', '11234', 'MafeRama','123456','123456', '1','Col Bella Oriente', pnCodigo12, pcMensaje12);
end;

Declare
    pnCodigo12 number;
    pcMensaje12 varchar2(200);
Begin
    SP_EditarUsuario('0801199911656','1', '33606018','1234', '3', 'RAFE28','123', '45Minutes','45Minutes','2','Residencial Concepcion', pnCodigo12, pcMensaje12);
end;


create or replace procedure SP_EditarUsuario(
    pcIdUsuario in varchar2,
    pnEstado in integer,
    pnTelefono in integer,
    pnContrato in integer,
    pnIdAreaTrabajo in integer,
    pcUsername in varchar2,
    pcContraseniaVieja in varchar2,
    pcContra1 in varchar2,
    pcContra2 in varchar2,
    pnIdTipoUsuario in varchar2,
    pcDireccion in varchar2,
    
    pnCodigo out integer,
    pcMensaje out varchar2
)
IS
	 vnConteo integer;
     vcTemp varchar2(200);
     vnIdUsuario varchar2(20);   
Begin
    pnCodigo:=0;
    pcMensaje:='';
    vnConteo:=0;
	vcTemp:='';
	vnIdUsuario:='';
    
    if pcidusuario='' or pcidusuario is null then
		vcTemp:='Campo requerido';
    end if;
    
    if pnEstado='' or pnEstado is null then
		vcTemp:='Campo requerido';
    end if;
    
    if pnTelefono='' or pnTelefono is null then
		vcTemp:='Campo requerido';
    end if;
    
    if pnContrato='' or pnContrato is null then
		vcTemp:='Campo requerido';
	end if;
    
	if pnIdAreaTrabajo='' or pnIdAreaTrabajo is null then
		vcTemp:='Campo requerido';
	end if;
    
	if pcUsername='' or  pcUsername is null then
		vcTemp:='Campo requerido';
    end if;

	if pcContraseniaVieja='' or pcContraseniaVieja is null then
		vcTemp:='Campo requerido';
	end if;

	if pcContra1='' or pcContra1 is null then
		vcTemp:='Campo requerido';
	end if;
	
	if pcContra2='' or pcContra2 is null then
		vcTemp:='Campo requerido';
	end if;

	if pnIdTipoUsuario='' or pnIdTipoUsuario is null then
		vcTemp:='Campo requerido';
	end if;
    
    if pcDireccion='' or pcDireccion is null then
		vcTemp:='Campo requerido';
    end if;
		
        Select count(*) into vnConteo from Usuario 
        where pcidusuario=idUsuario;
        
        IF vnConteo=1 then
        
                UPDATE PERSONA SET  telefono=pnTelefono, direccion=pcDireccion
                where pcidusuario=idPersona;
				UPDATE USUARIO SET username=pcUsername, contrasenia=pcContra1, contrato=pnContrato, estado=pnEstado,
					tipousuario_idtipousuario=pnIdTipoUsuario, areatrabajo_idareatrabajo=pnIdAreaTrabajo
                    where pcidusuario=idUsuario;
                pnCodigo:=1;
                pcMensaje:='Usuario editado exitosamente.';
                DBMS_OUTPUT.PUT_LINE(pnCodigo || pcMensaje);
                Return;
			  ELSE
				pnCodigo:=0;
                pcMensaje:='Error';
                DBMS_OUTPUT.PUT_LINE(pnCodigo || pcMensaje);
                Return;
			END IF;
        
END;
-----------------------INSUMO SP CON SUS RESPECTIVAS PRUEBAS----------
Declare
    pnCodigo123 number;
    pcMensaje123 varchar2(200);
Begin
    SP_RegistrarInsumo('RAFE28','45Minutes','Fertilizante','12/11/19','1234567', '3','122','50', pnCodigo123, pcMensaje123);
    dbms_output.put_line(pnCodigo123||' ' || pcMensaje123);
end;

create or replace procedure SP_RegistrarInsumo(
    pcUsername in varchar2,
	pcPassword in varchar2,
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

	if pcPassword='' or pcPassword is null then
		vcTemp:='Campo requerido';
	end if;
    
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
    
         
--Si no hay un insumo registrado con el mismo nombre
        select count(*) into vnConteo from Insumo 
        where pcNombreInsumo=nombreInsumo;
        
        SELECT idusuario into vnIdUsuario from Usuario
        where pcUsername=username;
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
		  pcMensaje:='Insumo registrado exitosamente.';
          Return;
			ELSE
				pnCodigo:=0;
				pcMensaje:='Usuario sin privilegio.';
                Return;
	 END IF;
END;

Declare
    pnCodigo123 number;
    pcMensaje123 varchar2(200);
Begin
    SP_EditarInsumo('GAMA17','44Minutes','1','1000','203.13', pnCodigo123, pcMensaje123);
    dbms_output.put_line(pnCodigo123||' ' || pcMensaje123);
end;

create or replace procedure SP_EditarInsumo(
    pcUsername in varchar2,
    pcPassword in varchar2,
    pnIdInsumo in  number,
    pnCantidad in number,
    pnPrecioUnitario in float,
    
    pnCodigo out  number,
    pcMensaje out varchar2
)
IS
    vnConteo number;
    vnIdUsuario varchar(13);
    vcTemp varchar(200);
Begin
	
    pnCodigo:=0;
    pcMensaje:='';
    vnConteo:=0;
	vcTemp:='';
	vnIdUsuario:='';

	
    if pcUsername='' or pcUsername is null then
		vcTemp:='Campo requerido';
	end if;

	if pcPassword='' or pcPassword is null then
		vcTemp:='Campo requerido';
	end if;
    
	if pnIdInsumo='' or pnIdInsumo is null then
		vcTemp:='Campo requerido';
	end if; 
    
	if pnCantidad='' or pnCantidad is null then
		vcTemp:='Campo requerido';
	end if;
    
    if pnpreciounitario='' or pnpreciounitario is null then
		vcTemp:='Campo requerido';
	end if;

		SELECT idUsuario into vnIdUsuario from Usuario 
		where pcUsername=username;
        If vnIdUsuario<>'' or vnIdUsuario is not null then 
		  UPDATE Insumo SET fechaCompra=SYSDATE, cantidad=pnCantidad, precio=pnPrecioUnitario,usuario_idusuario=vnIdUsuario
		  where pnIdInsumo=idInsumo;
		  pnCodigo:=1;
		  pcMensaje:='Insumo editado exitosamente.';
          Return;
		  ELSE
			pnCodigo:=0;
			pcMensaje:='Error'; 
            Return;
		END IF;
END;

----------PROVEEDOR SP CON SUS RESPECTIVAS PRUEBAS-----
Declare
    pnCodigo123 number;
    pcMensaje123 varchar2(200);
Begin
    sp_registrarproveedor('098765432','Don Gonzalo S.A','Col Bella Oriente','dgalo@gmail.com','1','2', pnCodigo123, pcMensaje123);
    dbms_output.put_line(pnCodigo123||' ' || pcMensaje123);
end;
create or replace procedure SP_RegistrarProveedor(
    pcRtnProv in varchar2,
	pcNombreProveedor in varchar2,
    pcDireccion in varchar2,
    pnTelefono in number,
    pcEmail in varchar2,
    pnEstado in number,
    pnIdTipoProveedor in number,

    pnCodigo out number,
    pcMensaje out varchar2
)
IS
    vnConteo number;
    vcTemp varchar(200);
BEGIN
    pnCodigo:=0;
    pcMensaje:='';
    vnConteo:=0;
	vcTemp:='';
    
    if pcRtnProv='' or pcRtnProv is null then
		vcTemp:='Campo requerido';
	end if;
        
    if pcNombreProveedor='' or pcNombreProveedor is null then
		vcTemp:='Campo requerido';
	end if;
        
	if pcDireccion='' or pcDireccion is null then
		vcTemp:='Campo requerido';
	end if;
        
	if pnTelefono='' or pnTelefono is null then
		vcTemp:='Campo requerido';
	end if;
	
    if pcEmail='' or pcEmail is null then
		vcTemp:='Campo requerido';
	end if;
        
	if pnEstado='' or pnEstado is null then
		vcTemp:='Campo requerido';
    end if;

	if pnIdTipoProveedor='' or pnIdTipoProveedor is null then
		vcTemp:='Campo requerido';
	end if;
        
		SELECT COUNT(*) INTO vnConteo FROM Proveedor WHERE rtnProveedor=pcrtnprov;
  
		IF vnConteo=0 THEN
		  INSERT INTO Proveedor(rtnProveedor, nombreProveedor, direccion, email, estado, tipoproveedor_idtipoproveedor)
		  VALUES(pcRtnProv,pcNombreProveedor, pcDireccion, pcEmail, pnEstado, pnIdTipoProveedor);
		  pnCodigo:=1;
		  pcMensaje:='Proveedor registrado correctamente';
		  ELSE
			pnCodigo:=0;
			pcMensaje:='RTN mal escrito o duplicado. Por favor ingresar uno nuevo.';
		END IF;
END;

Declare
    pnCodigo123 number;
    pcMensaje123 varchar2(200);
Begin
    sp_editarproveedor('098765432','2','Col Las Brisas','dgalo@gmail.com', pnCodigo123, pcMensaje123);
    dbms_output.put_line(pnCodigo123||' ' || pcMensaje123);
end;

create or replace procedure SP_EditarProveedor(
    pcRtnProv in varchar2,
    pnIdEstado in number,
    pcDireccion in varchar2,
    pnTelefono in number,
    pcEmail in varchar2,
    
    pnCodigo out number,
    pcMensaje out varchar2
)
IS
    vnConteo number;
    vcTemp varchar(200);
BEGIN
    pnCodigo:=0;
    pcMensaje:='';
    vnConteo:=0;
	vcTemp:='';
    
    if pcRtnProv='' or pcRtnProv is null then
		vcTemp:='Campo requerido';
	end if;
    
    if pcDireccion='' or pcDireccion is null then
		vcTemp:='Campo requerido';
	end if;
        
	if pnTelefono='' or pnTelefono is null then
		vcTemp:='Campo requerido';
	end if;
	
    if pcEmail='' or pcEmail is null then
		vcTemp:='Campo requerido';
	end if;
        
	if pnIdEstado='' or pnIdEstado is null then
		vcTemp:='Campo requerido';
    end if;
    
    IF pcrtnprov is not null then
        UPDATE Proveedor SET direccion=pcDireccion, email=pcEmail, estado=pnIdEstado
			where rtnProveedor=pcrtnprov;
		  pnCodigo:=1;
		  pcMensaje:='Proveedor editado';
		  ELSE
			pnCodigo:=0;
			pcMensaje:='Error';
		END IF;
END;

-------------SP PRODUCTO CON SUS RESPECTIVAS PRUEBAS-------

INSERT INTO TIPOPRODUCTO VALUES('1','Verdura');
INSERT INTO TIPOPRODUCTO VALUES('2', 'Hortaliza');

INSERT INTO PRODUCTO VALUES('1','CHILE MORRON LIBRA', '4500', '13.04', '1.96', '0.00', '0.00', '15.00', '1', '1');
INSERT INTO PRODUCTO VALUES('2', 'CHILE PIMIENTO LIBRA', '5500', '14.78', '2.21', '0.00', '0.00', '17', '1','2');
Declare
    pnCodigo123 number;
    pcMensaje123 varchar2(200);
Begin
    sp_registrarproducto('Lechuga Escarola','200','1','12.03','2.99','0.00','0.00','16.03','1', pnCodigo123, pcMensaje123);
    dbms_output.put_line(pnCodigo123||' ' || pcMensaje123);
end;
create or replace procedure SP_RegistrarProducto(
    pcNombreProducto in varchar2,
    pnCantidadDisponible in number,
    pnIdTipoProducto in number,
    pnPrecioCosto in FLOAT,
    pnImpuesto15 in float,
    pnImpuesto18 in FLOAT,
    pnDescuento in FLOAT,
    pnPrecioVenta in Float,
    pnEstado in FLOAT,
    
    pnCodigo out number,
    pcMensaje out varchar2
)
IS
    vnConteo number;
    vnIdProducto number;
    vcTemp varchar(200);
BEGIN
    pnCodigo:=0;
    pcMensaje:='';
    vnIdProducto:=0;
    vnConteo:=0;
	vcTemp:='';
    
    if pcNombreProducto='' or pcNombreProducto is null then
		vcTemp:='Campo requerido';
	end if;
        
	if pnCantidadDisponible='' or pnCantidadDisponible is null then
		vcTemp:='Campo requerido';
	end if;
        
	if pnPrecioCosto='' or pnPrecioCosto is null then
		vcTemp:='Campo requerido';
	end if;

    if pnImpuesto15='' or pnImpuesto15 is null then
		vcTemp:='Campo requerido';
	end if;
        
	if pnImpuesto18='' or pnImpuesto18 is null then
		vcTemp:='Campo requerido';
	end if;
        
	if pnDescuento='' or pnDescuento is null then
		vcTemp:='Campo requerido';
	end if;

	if pnPrecioVenta='' or pnPrecioVenta is null then
		vcTemp:='Campo requerido';
	end if;

	if pnEstado='' or pnEstado is null then
		vcTemp:='Campo requerido';
	end if;

	if pnIdTipoProducto='' or pnIdTipoProducto is null then
		vcTemp:='Campo requerido';
	end if;
    
    --Si no hay un insumo registrado con el mismo nombre
        select count(*) into vnConteo from Producto 
        where pcNombreProducto=nombreProducto;
        
--Entonces       
        IF vnConteo=0 then
--Contar más 1 los id de insumo, si habian 5, ahora tendra 6
                    Select count(*)+1 into vnIdProducto from Producto;
--Contar los insumos que tengan el mismo id  que sumamos anteriormente
                    Select count(*) into vnConteo from Producto 
                        where idProducto=vnIdProducto;
 --Si hay ya un insumo registrado con ese id entonces
                    if vnConteo=1 then
                        select max(idProducto)+1 into vnIdProducto from Producto;
                    end if;
		  INSERT INTO Producto(idProducto, nombreProducto, cantidadDisponible, precioCosto, impuesto15, impuesto18, descuento, precioVenta, estado, tipoproducto_idTipoProducto)
		  VALUES(vnIdProducto, pcNombreProducto, pnCantidadDisponible, pnPrecioCosto, pnImpuesto15, pnImpuesto18, pnDescuento, pnPrecioVenta, '1', pnIdTipoProducto);
		  pnCodigo:=1;
		  pcMensaje:='Producto registrado exitosamente.';
          Return;
			ELSE
				pnCodigo:=0;
				pcMensaje:='Error.';
                Return;
	 END IF;
END;
Declare
    pnCodigo123 number;
    pcMensaje123 varchar2(200);
Begin
    sp_editarproducto('4','2','2500','22.50','1.00','3.99','0.00', pnCodigo123, pcMensaje123);
    dbms_output.put_line(pnCodigo123||' ' || pcMensaje123);
end;
create or replace procedure SP_EditarProducto(
    pnIdProducto in number,
    pnEstado in number,
    pnCantidad in number,
    pnPrecioCosto in FLOAT,
    pnDescuento in FLOAT,
    pnImpuesto15 in FLOAT,
    pnImpuesto18 in FLOAT,
    
    pnCodigo out number,
    pcMensaje out varchar2
)
IS
    vnConteo number;
    vcTemp varchar(200);
BEGIN
    pnCodigo:=0;
    pcMensaje:='';
    vnConteo:=0;
	vcTemp:='';
    
    if pnIdProducto='' or pnIdProducto is null then
        vcTemp:='Campo requerido';
    end if;
    
    if pnEstado='' or pnEstado is null then
        vcTemp:='Campo requerido';
    end if;
    
    if pnCantidad='' or pnCantidad is null then
        vcTemp:='Campo requerido';
    end if;
    
    if pnPrecioCosto='' or pnPrecioCosto is null then
        vcTemp:='Campo requerido';
    end if;
    
    if pnDescuento='' or pnDescuento is null then
        vcTemp:='Campo requerido';
    end if;
    
    if pnImpuesto15='' or pnImpuesto15 is null then
        vcTemp:='Campo requerido';
    end if;
    
    if pnImpuesto18='' or pnImpuesto18 is null then
        vcTemp:='Campo requerido';
    end if;
    
    select count(*) into vnConteo from Producto
    where pnIdProducto=idProducto;
    
    if vnConteo=1 then
        Update Producto set estado=pnEstado, precioCosto=pnPrecioCosto, cantidadDisponible=pnCantidad,
        descuento=pnDescuento, impuesto15=pnImpuesto15, impuesto18=pnImpuesto18
        where idProducto=pnIdProducto;
            pnCodigo:=1;
            pcMensaje:='Producto editado';
		  ELSE
			pnCodigo:=0;
			pcMensaje:='Error';
		END IF;
END;
