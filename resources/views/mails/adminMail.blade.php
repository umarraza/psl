<head>
    <link href="https://fonts.googleapis.com/css?family=sans-serif" rel="stylesheet">
    <style>
    * {
        margin: 0;
        padding: 0;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    p {
        font-family: sans-serif !important;
        color: #3D3D3D !important;
    }

    * {
        font-family: sans-serif !important;
    }

    img {
        max-width: 100%;
    }

    .collapse {
        margin: 0;
        padding: 0;
    }

    body {
        -webkit-text-size-adjust: none;
        width: 100% !important;
        height: 100%;
    }


    /* ------------------------------------- 
        ELEMENTS 
------------------------------------- */

    /*a {
        color: #2BA6CB;
    }*/

    .btn {
        text-decoration: none;
        color: #FFF !important;
        background-color: #16baff;
        padding: 2px 25px;
        font-weight: bold;
        margin-right: 10px;
        text-align: center;
        cursor: pointer;
        display: inline-block;
    }

    p.callout {
        padding: 15px;
        background-color: #ECF8FF;
        margin-bottom: 15px;
    }


    table.social {
        background-color: #ebebeb;

    }

    .social .soc-btn {
        padding: 3px 7px;
        font-size: 12px;
        margin-bottom: 10px;
        text-decoration: none;
        color: #FFF;
        font-weight: bold;
        display: block;
        text-align: center;
    }

    .sidebar .soc-btn {
        display: block;
        width: 100%;
    }

    /* ------------------------------------- 
        HEADER 
------------------------------------- */

    table.head-wrap {
        width: 100%;
    }

    .header.container table td.logo {
        padding: 15px;
    }

    .header.container table td.label {
        padding: 15px;
        padding-left: 0px;
    }


    /* ------------------------------------- 
        BODY 
------------------------------------- */

    table.body-wrap {
        width: 100%;
    }

    h3.color {
        color: #3D3D3D !important;
    }

    head .span-font {
        font-size: 17px;
        font-weight: 100;
    }

    /* ------------------------------------- 
        FOOTER 
------------------------------------- */

    table.footer-wrap {
        width: 100%;
        clear: both !important;
    }

    .footer-wrap .container td.content p {
        border-top: 1px solid rgb(215, 215, 215);
        padding-top: 15px;
    }

    .footer-wrap .container td.content p {
        font-size: 10px;
        font-weight: bold;

    }


    /* ------------------------------------- 
        TYPOGRAPHY 
------------------------------------- */

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-family: sans-serif !important;
        color: #3D3D3D !important;
    }

    .abc {
        font-family: sans-serif !important;
        color: #3D3D3D !important;
    }

    h1 small,
    h2 small,
    h3 small,
    h4 small,
    h5 small,
    h6 small {
        font-size: 60%;
        color: #3D3D3D;
        line-height: 0;
        text-transform: none;
    }

    h1 {
        font-weight: 200;
        font-size: 44px;
    }

    h2 {
        font-weight: 200;
        font-size: 37px;
    }

    h3 {
        font-weight: 500;
        font-size: 27px;
    }

    h4 {
        font-weight: 500;
        font-size: 23px;
    }

    h5 {
        font-weight: 900;
        font-size: 17px;
    }

    h6 {
        font-weight: 900;
        font-size: 14px;
        text-transform: uppercase;
        color: #3D3D3D;
    }

    .collapse {
        margin: 0 !important;
    }

    p,
    ul {
        margin-bottom: 10px;
        font-weight: normal;
        font-size: 14px;
        line-height: 1.6;
    }

    p.lead {
        font-size: 17px;
        text-align: justify;
    }

    p.last {
        margin-bottom: 0px;
    }

    ul li {
        margin-left: 5px;
        list-style-position: inside;
    }



    /* --------------------------------------------------- 
        RESPONSIVENESS
        Nuke it from orbit. It's the only way to be sure. 
------------------------------------------------------ */

    /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */

    .container {
        display: block !important;
        max-width: 600px !important;
        /*margin: 0 auto !important;*/
        /* makes it centered */
        clear: both !important;
    }

    /* This should also be a block element, so that it will fill 100% of the .container */

    .content {
        padding: 15px;
        max-width: 600px;
        /*margin: 0 auto;*/
        display: block;
    }

    /* Let's make sure tables in the content area are 100% wide */

    .content table {
        width: 100%;
    }


    /* Odds and ends */

    .column 
    {
        width: 300px;
        float: left;
    }

    .column tr td 
    {
        padding: 15px;
    }

    .column-wrap 
    {
        padding: 0 !important;
        margin: 0 auto;
        max-width: 600px !important;
    }

    .column table 
    {
        width: 100%;
    }

    .social .column {
        width: 280px;
        min-width: 279px;
        float: left;
    }

    /* Be sure to place a .clear element after each set of columns, just to be safe */

    .clear {
        display: block;
        clear: both;
    }


    /* --------------------------------------- 
        PHONE
        For clients that support media queries.
        Nothing fancy. 
	---------------------------------------- */

    @media only screen and (max-width: 600px) {

        a[class="btn"] {
            display: block !important;
            margin-bottom: 10px !important;
            background-image: none !important;
            margin-right: 0 !important;
        }

        div[class="column"] {
            width: auto !important;
            float: none !important;
        }

        table.social div[class="column"] {
            width: auto !important;
        }

    }
    .newClass{
    	font-size: 1.0rem !important;background-color: #2ae840 !important;
	   	letter-spacing: .25px !important;
	   	border-radius: 4px !important;
	   	box-sizing: border-box !important;
	   	color: #ffffff !important;
	   	cursor: pointer !important;
	   	font-weight: 600 !important;
	   	background-color: #19baff;
	   	height: 36px !important;
	   	padding: 8px 33px !important;
	   	text-align: center !important;
	   	box-shadow: inset 0 0 0 1px #dadce0 !important;
	   	user-select: none !important;
	   	text-decoration: none !important;
	}
	.newClass:hover
	{
		background-color: #2ae840 !important;
		color:#ffffff !important;
	}

    
</style>
</head>
<body bgcolor="#FFFFFF">

    <div class="row" style="background-color:#2ae840">
    	<br>
        <center>
            <img src="{{ url('/public/logos/logo1.png') }}"
                                    width="300px" height="150px" />
        </center>
        <br>
    </div>

    <p class="lead">Hey, <b>{{$firstName}}</b>!

    <p class="lead">{{$content}}</p>

    {{-- <a class="newClass" 
        target="_blank" href="{{ url('/waves/#/resetPassword/'.$userId.'/'.$token)}}">Reset Password</a> --}}
    
    <br>
    <br>
    
    <p class="lead">Stay Awesome,<br>The Gold Spring Team</p>
    
    <br>
    <br>
	
	<div class="row" style="background-color:#f7f7f7">
	    <center><br>
	            Copyright© 2019 Gold Spring, Inc, All rights reserved.
	            <br>
	            <br>
	    </center>
	</div>
</body>
    
