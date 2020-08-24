create or replace NONEDITIONABLE procedure SP_EditarProducto(
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
    vnPrecioVenta number;
    vnValorQuince number;
    vnValorDieciocho number;
    vnValorDescuento number;
BEGIN
    pnCodigo:=0;
    pcMensaje:='';
    vnConteo:=0;
	vcTemp:='';
    vnPrecioVenta := 0;
    vnValorQuince := 0;
    vnValorDieciocho := 0;
    vnValorDescuento :=0;

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

    if(pnImpuesto15 = 1)  then
     vnValorQuince := pnPrecioCosto*0.15;
    end if;

    if(pnImpuesto18 = 1)  then
     vnValorDieciocho :=  pnPrecioCosto*0.18;
    end if;
    
    if (pnDescuento >0 ) then
     vnvalordescuento :=  (pnPrecioCosto * pnDescuento)/100;
    end if;

    vnPrecioVenta :=  pnPrecioCosto +  vnValorDieciocho  +vnValorQuince - vnvalordescuento;

    if vnConteo=1 then
        Update Producto 
        set estado=pnEstado,
            precioCosto=pnPrecioCosto,
            cantidadDisponible=pnCantidad,
            descuento=pnDescuento, 
            impuesto15=pnImpuesto15,
            impuesto18=pnImpuesto18,
            precioventa = vnPrecioVenta
        where idProducto=pnIdProducto;
            pnCodigo:=1;
            pcMensaje:='Producto editado';
		  ELSE
			pnCodigo:=0;
			pcMensaje:='Error';
		END IF;
END;