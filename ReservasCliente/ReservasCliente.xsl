<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:template match="/">
    <html class="infotel">
            <head>
                <meta charset="utf-8"/>
                <meta name="viewport" content="width=device-width, initial-scale=1"/>

                <!-- own CSS styles -->
                <link rel="stylesheet/less" type="text/css" href="styles.less" />
                <!-- Bootstrap CSS -->
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"/>
            </head>
            <body>
                <h2 style="text-align:center;">
                    RESERVAS DE LOS CLIENTES DE LA CADENA DE HOTELES INFOTEL
                </h2>
                <br/>
                <xsl:apply-templates select="//CLIENTE" />
                <br/>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
                <script src="https://cdn.jsdelivr.net/npm/less@4" ></script>  
            </body>
        </html>
    </xsl:template>

    <xsl:template match="CLIENTE">
        <table width="60vw" class="table table-bordered">
            <tr>
                <th colspan="12" class="cliente">
                    CLIENTE <xsl:value-of select="@nif" />
                </th>
            </tr>
            <tr>
                <th scope="row"  colspan="12">Reserva de Habitaciones</th>
            </tr>
            <tr>
                <th scope="col">codigo</th>
                <th scope="col">fechaInicio</th>
                <th scope="col">fechaFin</th>
                <th scope="col">precioTotal</th>
                <th scope="col">idHabitacion</th>
                <th scope="col">numHabitacion</th>
                <th scope="col">habitacionLimpia</th>
                <th scope="col">habitacionOcupada</th>
                <th scope="col">idOferta</th>
                <th scope="col">codOferta</th>
                <th scope="col">Descuento</th>
            </tr>
            <xsl:apply-templates select="RESERVAHIST" />
            <tr>
                <th  colspan="12">Reserva de Servicios</th>
            </tr>
            <tr>
                <th scope="col" colspan="2">codigo</th>
                <th scope="col">fechaInicio</th>
                <th scope="col">fechaFin</th>
                <th scope="col">precioTotal</th>
                <th scope="col">idServicio</th>
                <th scope="col">nombreServicio</th>
                <th scope="col">precioBase</th>
                <th scope="col">idEmpleado</th>
                <th scope="col" colspan="2">nifEmpleado</th>
            </tr>
            <xsl:apply-templates select="RESERVASERVICIO" />
        </table>
    </xsl:template>

    <xsl:template match="RESERVAHIST">
        <tr>
            <td><xsl:value-of select="RESERVA/@codigo" /></td>
            <td><xsl:value-of select="RESERVA/@fechaInicio" /></td>
            <td><xsl:value-of select="RESERVA/@fechaFinal" /></td>
            <td><xsl:value-of select="RESERVA/@precioTotal" /></td>
            <td><xsl:value-of select="HABITACION/@id" /></td>
            <td><xsl:value-of select="HABITACION/@numero" /></td>
            <td><xsl:value-of select="HABITACION/@estaLimpia" /></td>
            <td><xsl:value-of select="HABITACION/@estaOcupado" /></td>
            <td><xsl:value-of select="OFERTA/@id" /></td>
            <td><xsl:value-of select="OFERTA/@codigo" /></td>
            <td><xsl:value-of select="OFERTA/@descuento" /></td>
        </tr>
    </xsl:template>

    <xsl:template match="RESERVASERVICIO" class="servicios">
        <tr>
            <td colspan="2"><xsl:value-of select="RESERVA/@codigo" /></td>
            <td><xsl:value-of select="RESERVA/@fechaInicio" /></td>
            <td><xsl:value-of select="RESERVA/@fechaFinal" /></td>
            <td><xsl:value-of select="RESERVA/@precioTotal" /></td>     
            <td><xsl:value-of select="SERVICIO/@id" /></td>
            <td><xsl:value-of select="SERVICIO/@nombre" /></td>
            <td><xsl:value-of select="SERVICIO/@precioBase" /></td>
            <td><xsl:value-of select="EMPLEADO/@id" /></td>
            <td colspan="2"><xsl:value-of select="EMPLEADO/@nif" /></td>
        </tr>
    </xsl:template>
</xsl:stylesheet>