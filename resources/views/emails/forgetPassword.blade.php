{{--<h1>Forget Password Email</h1>--}}

{{--You can reset password from bellow link:--}}
{{--<a href="{{ route('reset.password.get', $token) }}">Reset Password</a>--}}


    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>rasekhon email</title>

    <style>
        @font-face {
            font-family: "Cairo";
            font-style: normal;
            font-weight: 400;
            src: url("fonts/cairo-v4-latin-ext_latin_arabic-regular.eot");
            /* IE9 Compat Modes */
            src: local("Cairo"), local("Cairo-Regular"),
            url("fonts/cairo-v4-latin-ext_latin_arabic-regular.eot?#iefix")
            format("embedded-opentype"),
                /* IE6-IE8 */
            url("fonts/cairo-v4-latin-ext_latin_arabic-regular.woff2")
            format("woff2"),
                /* Super Modern Browsers */
            url("fonts/cairo-v4-latin-ext_latin_arabic-regular.woff")
            format("woff"),
                /* Modern Browsers */
            url("fonts/cairo-v4-latin-ext_latin_arabic-regular.ttf")
            format("truetype"),
                /* Safari, Android, iOS */
            url("fonts/cairo-v4-latin-ext_latin_arabic-regular.svg#Cairo")
            format("svg");
            /* Legacy iOS */
        }
        html {
            height: 100%;
        }
        body {
            font-family: "Cairo", sans-serif;
            height: 100%;
        }
    </style>
</head>

<body>
<table
    style="
        width: 100%;
        padding: 30px 0;
        height: 100%;
        background: #f5f5f5;
        color: #737373;
        font-size: 14px;
        line-height: 1.4rem;
      "
>
    <tbody>
    <tr>
        <td>
            <style>
                * {
                    margin: 0;
                    padding: 0;
                }
            </style>
            <table
                id="main-wrapper"
                style="
                width: 100%;
                max-width: 600px;
                margin: 0 auto;
                background: #fff;
                border-radius: 20px;
                border: 15px solid #2190d5; /*background: #093b56;background: #2190d5;*/
                border-left: 0;
                border-right: 0;
              "
            >
                <tbody>
                <tr>
                    <td>
                        <table
                            id="header"
                            style="
                        width: calc(100% - 40px);
                        margin: 0 20px;
                        padding: 20px 0;
                        border-bottom: 2px solid #f5f5f5;
                      "
                        >
                            <tbody>
                            <tr>
                                <td style="font-size: 20px; color: #535353">
                                    <strong>Reset password</strong>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table
                            id="main-content"
                            style="
                        width: calc(100% - 40px);
                        margin: 10px 10px 0;
                        padding: 10px 10px 0;
                      "
                        >
                            <tbody>
                            <tr class="main-content-container">
                                <td>
                                    <h4 style="margin-bottom: 5px; font-size: 15px">
                                        Hi {{$user?->name}} ,
                                    </h4>
                                    <p style="margin-bottom: 20px">
                                        There was a request to change your password!  <br />
                                        If you did not make this request then please
                                        ignore this email.<br />
                                        Otherwise, please click this link to change your
                                        password:
                                        <a  href="{{ route('reset.password.get', $token) }}" style="color: blue">Reset</a>
                                    </p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
