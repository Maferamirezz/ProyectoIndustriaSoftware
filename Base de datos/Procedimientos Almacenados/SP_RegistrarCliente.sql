create or replace NONEDITIONABLE procedure SP_RegistrarCliente(
    pcNombreCliente in varchar2,
    pnEstado in FLOAT,
    pcDireccion in varchar2,
    pcTelefono in VARCHAR2,
    pnIdTipoCliente in number,
    
    pnCodigo out number,
    pcMensaje out varchar2
)
IS
    vnConteo number;
    vnIdCliente number;
    vcTemp varchar(200);


BEGIN
    pnCodigo:=0;
    pcMensaje:='';
    vnIdCliente:=0;
    vnConteo:=0;
	vcTemp:='';

    if pcNombreCliente='' or pcNombreCliente is null then
		vcTemp:='Campo requerido';
	end if;

    if pnEstado='' or pnEstado is null then
		vcTemp:='Campo requerido';
	end if;

	if pcDireccion='' or pcDireccion is null then
		vcTemp:='Campo requerido';
	end if;

    if pcTelefono='' or pcTelefono is null then
		vcTemp:='Campo requerido';
	end if;

	if pnIdTipoCliente='' or pnIdTipoCliente is null then
		vcTemp:='Campo requerido';
	end if;

    --Si no hay un insumo registrado con el mismo nombre
        select count(*) into vnConteo from Cliente 
        where pcNombreCliente=nombrecliente;

--Entonces       
        IF vnConteo=0 then
--Contar más 1 los id de insumo, si habian 5, ahora tendra 6
                    Select count(*)+1 into vnIdCliente from Cliente;
--Contar los insumos que tengan el mismo id  que sumamos anteriormente
                    Select count(*) into vnConteo from Cliente 
                        where idCliente=vnIdCliente;
 --Si hay ya un insumo registrado con ese id entonces
                    if vnConteo=1 then
                        select max(idCliente)+1 into vnIdCliente from Cliente;
                    end if;
		  INSERT INTO Cliente(idCliente, nombreCliente, estado, direccion, telefono, tipocliente_idTipocliente)
		  VALUES(vnIdCliente, pcNombreCliente, '1', pcdireccion, pctelefono, pnidtipocliente);
		  pnCodigo:=1;
		  pcMensaje:='Producto registrado exitosamente.';
          Return;
			ELSE
				pnCodigo:=0;
				pcMensaje:='Error al insertar el insumo.';
                Return;
	 END IF;
END;