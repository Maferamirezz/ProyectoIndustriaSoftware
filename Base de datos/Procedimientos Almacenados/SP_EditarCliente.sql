create or replace NONEDITIONABLE procedure SP_EditarCliente(
    pnIdCliente in number,
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
    vcTemp varchar(200);
BEGIN
    pnCodigo:=0;
    pcMensaje:='';
    vnConteo:=0;
	vcTemp:='';

    select count(*) into vnConteo from Cliente
    where pnIdCliente=idCliente;

    if vnConteo=1 then
        Update Cliente set estado=pnEstado, nombrecliente=pcnombrecliente, direccion=pcdireccion,
        telefono=pctelefono, tipocliente_idtipocliente=pnidtipocliente
        where idcliente=pnIdCliente;
            pnCodigo:=1;
            pcMensaje:='Producto editado';
		  ELSE
			pnCodigo:=0;
			pcMensaje:='Error';
		END IF;
END;