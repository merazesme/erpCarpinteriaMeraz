<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title></title>
        <style media="screen">
            body {
              font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
              font-size: 1rem;
              font-weight: normal;
              line-height: 1.5;
              color: #212529;
              background-color: #fff;
            }

            h1, h2, h3, h4, h5, h6 {
              margin-top: 0;
              margin-bottom: .5rem;
            }

            h1, .h1 {
              font-size: 2.5rem;
            }

            h2, .h2 {
              font-size: 2rem;
            }

            h3, .h3 {
              font-size: 1.75rem;
            }

            h4, .h4 {
              font-size: 1.5rem;
            }

            h5, .h5 {
              font-size: 1.25rem;
            }

            h6, .h6 {
              font-size: 1rem;
            }

            h1, h2, h3, h4, h5, h6,
            .h1, .h2, .h3, .h4, .h5, .h6 {
              margin-bottom: 0.5rem;
              /* font-family: inherit; */
              font-weight: 500;
              line-height: 1.1;
              color: inherit;
            }
            .container {
              padding-right: 15px;
              padding-left: 15px;
            }
            .mt-5 {
              margin-top: 3rem !important;
            }

            .mt-3 {
              margin-top: 1rem !important;
            }

            .mt-7 {
              margin-top: 5rem !important;
            }

            .float-right {
              float: right !important;
            }
            .d-inline {
              display: inline !important;
            }

            .d-inline-block {
              display: inline-block !important;
            }

            .w-100{
                width: 100%;
            }

            .center{
                text-align: center;
            }

            .right{
                text-align: right;
            }

        </style>
    </head>
    <body>
        <h6>Esperamos que esté teniendo un buen día.</h6>
        <h6>Agradecemos la confianza, a continuación adjuntamos su cotización.</h6>
        <h6>Las fechas establecidas son las siguientes:</h6>
        <ul>
            <li>
                <h6 style="margin-left:5px;">Fecha de inicio: {{date("d-m-Y", strtotime($data->fecha_inicio))}}</h6>
            </li>
            <li>
                <h6 style="margin-left:5px;">Fecha de terminación: {{date("d-m-Y", strtotime($data->fecha_fin))}}</h6>
            </li>
        </ul>
        <div class="center mt-3" style="">
            <h6>Saludos.</h6>
            <h6>Ing. Manuel de Jésus Meráz Gutiérrez</h6>
            <div style="border: 1px solid #2f2f2f;border-style: dotted;">
                <span style="background-color: #068f41;color: white;font-size:.90rem">
                    Av. Alfonso G. Calderón M-11 L-19 Col. Libertad de Expresión Maz. Sin. Tel.  9 86-97-99 cel. 044 669-116-04-91
                </span>
            </div>
            <div class="">
                <a href="mailto:megm_2@hotmail.com">megm_2@hotmail.com</a>
            </div>
        </div>
    </body>
</html>
