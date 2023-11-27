<head>
    <style>
        .fa {
            display: inline-block;
            font: normal normal normal 14px/1 FontAwesome;
            font-size: inherit;
            text-rendering: auto;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            transform: translate(0, 0);
        }
        .fa-angle-up:before {
            content: "\f106";
        }

        .fa-angle-down:before {
            content: "\f107";
        }

        a {
            background-color: transparent;
        }

        a:active,
        a:hover {
            outline: 0;
        }

        b,
        strong {
            font-weight: 700;
        }

        img {
            border: 0;
        }

        button,
        input,
        textarea {
            margin: 0;
            font: inherit;
            color: inherit;
        }

        button {
            overflow: visible;
        }

        button {
            text-transform: none;
        }

        button,
        input[type=submit] {
            -webkit-appearance: button;
            cursor: pointer;
        }

        input {
            line-height: normal;
        }

        textarea {
            overflow: auto;
        }

        table {
            border-spacing: 0;
            border-collapse: collapse;
        }

        td,
        th {
            padding: 0;
        }

        @media print {

            *,
            :after,
            :before {
                color: #000 !important;
                text-shadow: none !important;
                background: 0 0 !important;
                -webkit-box-shadow: none !important;
                box-shadow: none !important;
            }

            a,
            a:visited {
                text-decoration: underline;
            }

            a[href]:after {
                content: " ("attr(href) ")";
            }

            a[href^="javascript:"]:after {
                content: "";
            }

            img,
            tr {
                page-break-inside: avoid;
            }

            img {
                max-width: 100% !important;
            }
        }

        * {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        :after,
        :before {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        button,
        input,
        textarea {
            font-family: inherit;
            font-size: inherit;
            line-height: inherit;
        }

        a {
            color: #337ab7;
            text-decoration: none;
        }

        a:focus,
        a:hover {
            color: #23527c;
            text-decoration: underline;
        }

        a:focus {
            outline: thin dotted;
            outline: 5px auto -webkit-focus-ring-color;
            outline-offset: -2px;
        }

        img {
            vertical-align: middle;
        }

        ul {
            margin-top: 0;
            margin-bottom: 10px;
        }

        .container {
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
            width: %100;
        }

        table {
            background-color: transparent;
        }

        th {
            text-align: left;
        }

        input[type=file] {
            display: block;
        }

        input[type=file]:focus {
            outline: thin dotted;
            outline: 5px auto -webkit-focus-ring-color;
            outline-offset: -2px;
        }

        .form-control {
            display: block;
            width: 100%;
            height: 34px;
            padding: 6px 12px;
            font-size: 14px;
            line-height: 1.42857143;
            color: #555;
            background-color: #fff;
            background-image: none;
            border: 1px solid #ccc;
            border-radius: 4px;
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
        }

        .form-control:focus {
            border-color: #66afe9;
            outline: 0;
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgba(102, 175, 233, .6);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgba(102, 175, 233, .6);
        }

        .form-control[readonly] {
            cursor: not-allowed;
            background-color: #eee;
            opacity: 1;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .input-sm {
            height: 30px;
            padding: 5px 10px;
            font-size: 12px;
            line-height: 1.5;
            border-radius: 3px;
        }

        .btn {
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -ms-touch-action: manipulation;
            touch-action: manipulation;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-image: none;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .btn:active:focus,
        .btn:focus {
            outline: thin dotted;
            outline: 5px auto -webkit-focus-ring-color;
            outline-offset: -2px;
        }

        .btn:focus,
        .btn:hover {
            color: #333;
            text-decoration: none;
        }

        .btn:active {
            background-image: none;
            outline: 0;
            -webkit-box-shadow: inset 0 3px 5px rgba(0, 0, 0, .125);
            box-shadow: inset 0 3px 5px rgba(0, 0, 0, .125);
        }

        .btn-xs {
            padding: 1px 5px;
            font-size: 12px;
            line-height: 1.5;
            border-radius: 3px;
        }

        .fade {
            opacity: 0;
            -webkit-transition: opacity .15s linear;
            -o-transition: opacity .15s linear;
            transition: opacity .15s linear;
        }

        .fade.in {
            opacity: 1;
        }

        .input-group {
            position: relative;
            display: table;
            border-collapse: separate;
        }

        .input-group .form-control {
            position: relative;
            z-index: 2;
            float: left;
            width: 100%;
            margin-bottom: 0;
        }

        .input-group-sm>.form-control,
        .input-group-sm>.input-group-addon {
            height: 30px;
            padding: 5px 10px;
            font-size: 12px;
            line-height: 1.5;
            border-radius: 3px;
        }

        .input-group .form-control,
        .input-group-addon,
        .input-group-btn {
            display: table-cell;
        }

        .input-group .form-control:not(:first-child):not(:last-child),
        .input-group-addon:not(:first-child):not(:last-child) {
            border-radius: 0;
        }

        .input-group-addon,
        .input-group-btn {
            width: 1%;
            white-space: nowrap;
            vertical-align: middle;
        }

        .input-group-addon {
            padding: 6px 12px;
            font-size: 14px;
            font-weight: 400;
            line-height: 1;
            color: #555;
            text-align: center;
            background-color: #eee;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .input-group-btn {
            position: relative;
            font-size: 0;
            white-space: nowrap;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .alert-dismissible {
            padding-right: 35px;
        }

        .alert-danger {
            color: #a94442;
            background-color: #f2dede;
            border-color: #ebccd1;
        }

        .close {
            float: right;
            font-size: 21px;
            font-weight: 700;
            line-height: 1;
            color: #000;
            text-shadow: 0 1px 0 #fff;
            filter: alpha(opacity=20);
            opacity: .2;
        }

        .close:focus,
        .close:hover {
            color: #000;
            text-decoration: none;
            cursor: pointer;
            filter: alpha(opacity=50);
            opacity: .5;
        }

        button.close {
            -webkit-appearance: none;
            padding: 0;
            cursor: pointer;
            background: 0 0;
            border: 0;
        }

        .clearfix:after,
        .clearfix:before,
        .container:after,
        .container:before,
        .modal-footer:after,
        .modal-footer:before {
            display: table;
            content: " ";
        }

        .clearfix:after,
        .container:after,
        .modal-footer:after {
            clear: both;
        }

        a:focus,
        a:hover {
            color: gray;
        }

        .sepetmain {
            width: 100%;
            margin: auto;
            background-color: #f8f7f5;
        }

        .sepettitle {
            list-style: none;
            margin: 0;
            padding: 0;
            display: block;
            margin: auto;
            width: 100%;
            font-weight: bold;
            margin-bottom: 10px;
            text-align: center;
            padding: 20px 0 10px 0;
            color: #9C8D7D;
        }

        .SEPETSAG {
            color: black;
            width: calc(25% - 10px);
            margin: 5px;
            float: left;
            border-radius: 6px;
            background-color: white;
        }

        .sepetozetrow {
            position: relative;
            width: 100%;
            text-align: left;
            padding: 24px;
        }

        .SEPETSOL {
            padding: 40px 50px;
            background-color: white;
            color: black;
            width: calc(75% - 10px);
            margin: 5px;
            float: left;
            border-radius: 5px;
        }

        a,
        a:focus,
        a:hover,
        a:active {
            outline: 0;
            text-decoration: none;
        }

        .margin-bottom-40 {
            margin-bottom: 40px !important;
        }

        input.form-control {
            border-color: #ECF1F3;
            border-width: 2px;
            border-radius: 5px;
            color: #777;
            font-family: 'Kumbh Sans', sans-serif;
            box-shadow: none;
        }

        input.form-control:focus {
            box-shadow: none;
            border: solid 2px #dbdbdb;
        }

        .clearfix:after {
            content: ".";
            display: block;
            height: 0;
            clear: both;
            visibility: hidden;
            font-size: 0;
            line-height: 0;
        }

        ::-webkit-scrollbar {
            width: 12px;
        }

        ::-webkit-scrollbar-track {
            background-color: #eaeaea;
            border-left: 1px solid #cecece;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #cecece;
        }

        ::-webkit-scrollbar-thumb:hover {
            background-color: #aaa;
        }

        ::-webkit-scrollbar-track {
            border-radius: 0;
            box-shadow: none;
            border: 0;
        }

        ::-webkit-scrollbar-thumb {
            border-radius: 0;
            box-shadow: none;
            border: 0;
        }

        ::selection {
            color: #fff;
            background: #e45000;
        }

        .shopping-total {
            width: 100%;
            padding: 9px 24px;
            border-top: 1px solid #ddd;
        }

        .shopping-total ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .shopping-total li {
            border-bottom: solid 1px #ecebeb;
            width: 100%;
            overflow: hidden;
            padding: 9px 0;
        }

        .shopping-total li:last-child {
            border: none;
        }

        .shopping-total em {
            font: 18px 'Kumbh Sans', 'PT Sans Narrow', sans-serif;
            float: left;
            position: relative;
            top: 2px;
        }

        .shopping-total strong {
            color: #000;
            font: 18px "'Kumbh Sans'", sans-serif;
            font-weight: normal;
            float: right;
        }

        .shopping-total strong span {
            font-size: 17px;
        }

        .shopping-total-price {
            font-weight: bold;
        }

        .shopping-total-price strong {
            font-weight: bold;
        }

        *:focus {
            outline: none;
        }

        .product-quantity,
        .product-quantity .input-group {
            width: 70px;
            float: left;
            margin-right: 20px;
            position: relative;
            overflow: hidden;
        }

        table .product-quantity,
        table .product-quantity .input-group {
            margin-right: 0;
        }

        .product-quantity input.form-control {
            border: none;
            background: #edeff1 !important;
            font: 300 23px 'Kumbh Sans', sans-serif;
            ;
            color: #647484;
            height: 38px;
            width: 50px;
            text-align: center;
            padding: 5px;
        }

        .product-quantity input.form-control:focus {
            border: none;
        }

        .product-quantity .input-group-btn {
            position: static;
        }

        .product-quantity .btn {
            text-align: center;
            height: 18px !important;
            width: 18px;
            padding: 0 2px 0 1px !important;
            text-align: center;
            background: #edeff1;
            border-radius: 0 !important;
            font-size: 18px !important;
            line-height: 1 !important;
            color: #616b76;
            margin: 0 !important;
            position: absolute;
            right: 0;
        }

        .product-quantity .quantity-up {
            top: 0;
        }

        .product-quantity .quantity-down {
            bottom: 0;
        }

        .product-quantity .btn i {
            position: relative;
            top: -2px;
            left: 1px;
        }

        @media (max-width: 992px) {
            .product-quantity {
                margin-bottom: 10px;
            }
        }

        @media (max-width: 1024px) {

            input[type="tel"],
            input[type="text"],
            textarea {
                font-size: inherit;
            }

            .SEPETSAG {
                background-color: #FFF;
                color: black;
                margin: 0;
                padding: 10px;
                width: calc(100% - 20px);
                margin: 10px;
            }

            .SEPETSOL {
                margin: 0;
                color: black;
                width: 100%;
                margin-TOP: 5px;
            }
        }

        ::selection {
            color: #fff;
            background: #e45000;
        }

        .shopping-total strong {
            color: #000;
        }

        .sepetitem {
            height: auto;
            overflow: overlay;
            padding: 10px;
            width: 100%;
            border: 1px solid #e6e6e6;
            border-radius: 5px 5px 0 0;
        }

        a {
            color: #000;
        }

        a {
            color: black;
        }

        .container {
            width: 100%;
            padding: 0;
            margin: auto;
        }

        .popup-close {
            display: inline-block;
            position: absolute;
            top: 11px;
            right: 11px;
            background-size: cover;
            width: 12px;
            height: 12px;
            background-image: url('data:image/svg+xml;charset%3DUS-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2227%22%20height%3D%2227%22%20viewBox%3D%220%200%2027%2027%22%3E%3Cpath%20d%3D%22M0%2025.7L25.7%200l1.3%201.3%20-25.7%2025.7L0%2025.7z%22%2F%3E%3Cpath%20d%3D%22M25.7%2027L0%201.3%201.3%200l25.7%2025.7L25.7%2027z%22%2F%3E%3C%2Fsvg%3E');
            background-repeat: no-repeat;
            cursor: pointer;
        }

        .product-quantity {
            display: none;
        }

        img {
            max-width: 100%;
        }

        .form-group {
            margin-bottom: 0;
        }

        .form-control {
            font-size: 14px;
            font-weight: normal;
            color: #333;
            background-color: #fff;
            border: 1px solid #e5e5e5;
            box-shadow: none;
            transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            -ms-border-radius: 4px;
            -o-border-radius: 4px;
            border-radius: 4px;
            height: 40px;
        }

        .green.btn {
            background-color: #eec4a5;
            border-radius: 5px;
            padding: 10px;
            color: #FFFFFF;
            width: 100%;
            margin-top: 20px;
            padding: 20px 0 20px 0;
        }

        .green.btn:hover,
        .green.btn:focus,
        .green.btn:active {
            color: #FFFFFF;
            background-color: #e7cdb2;
        }

        .sepetopdiv {
            width: 50%;
            float: left;
        }

        @media (max-width: 1024px) {
            .sepetopdiv {
                width: 100%;
                float: left;
            }
        }

        .sepeteklebtn {
            background-color: #1d3435;
            border-radius: 6px;
            padding: 10px;
            cursor: pointer;
            display: inline-block;
            margin-top: 24px;
        }

        .sepeteklebtn:hover {
            background-color: #e7cdb2;
        }

        .sepetmain .container {
            max-width: 1150px;
            width: 100%;
            margin: auto;
        }

        .sepetozetsecond {
            vertical-align: top;
            padding-bottom: 8px;
            font-size: 12px;
        }

        .sepetozetsecond2 {
            text-align: right;
            vertical-align: top;
            width: 70px;
            padding-bottom: 8px;
            font-size: 12px;
        }

        a:focus,
        a:hover {
            color: black;
        }

        .adreseklebtn {
            text-align: center;
            padding: 10px;
            color: #1D413F;
            font-weight: bold;
            width: 100%;
            border: 1px solid #e6e6e6;
            border-top: none;
            border-radius: 0 0 5px 5px;
        }

        .adreseklebtn>span {
            background-color: #e7cdb2;
            text-align: center;
            padding: 7px 30px;
            color: #1D413F;
            font-weight: bold;
            width: auto;
            border: 0.5px solid #1d3435;
            border-radius: 6px;
            cursor: pointer;
            letter-spacing: 1px;
            margin: 10px;
            display: inline-block;
            background-size: 16px;
            background-repeat: no-repeat;
            background-position: center left 10px;
            padding-left: 40px;
        }

        .adreseklebtn2 {
            padding: 14px;
            color: #1D413F;
            font-weight: bold;
            width: 100%;
            cursor: pointer;
            text-align: left;
            position: relative;
            font-size: 12px;
            font-weight: normal;
        }



        #MainContent_sepet_sepet1_kuponButton1 {
            width: 100%;
            background-color: #e7cdb2;
            font-size: 15px;
        }

        .SEPETSOL {
            padding: 0px 50px 15px 50px;
            background-color: white;
            color: black;
            width: calc(75% - 10px);
            margin: 5px;
            float: left;
            border-radius: 5px;
        }

        .sepeturuntitle {
            display: block;
            font-size: 15px;
            font-weight: bold;
            padding: 25px 0 15px 0;
        }

        .sepetfiyat {
            float: right;
            padding-top: 30px;
            padding-right: 40px;
            font-weight: bold;
        }

        .urunitemdiv {
            width: 50%;
            float: left;
            padding-top: 5px;
        }

        @media (max-width:500px) {
            .urunitemdiv {
                width: 60%;
                float: left;
                padding-top: 5px;
            }

            .sepeturuntitle {
                font-size: 15px;
                font-weight: bold;
                padding: 0px 0 10px 0;
                font-family: 'Playfair Display', serif;
            }

            .sepetfiyat {
                float: right;
                padding-top: 15px;
                padding-right: 20px;
                font-weight: bold;
            }

            .SEPETSAG {
                margin-top: 35px;
            }

            .SEPETSOL {
                padding: 0px 10px 15px 10px;
                width: calc(100% - 20px);
                margin: 10px;
            }
        }

        .popup-close {
            display: inline-block;
            position: absolute;
            top: 11px;
            right: 11px;
            background-size: cover;
            width: 12px;
            height: 12px;
            background-image: url(data:image/svg+xml;charset%3DUS-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2227%22%20height%3D%2227%22%20viewBox%3D%220%200%2027%2027%22%3E%3Cpath%20d%3D%22M0%2025.7L25.7%200l1.3%201.3%20-25.7%2025.7L0%2025.7z%22%2F%3E%3Cpath%20d%3D%22M25.7%2027L0%201.3%201.3%200l25.7%2025.7L25.7%2027z%22%2F%3E%3C%2Fsvg%3E);
            background-repeat: no-repeat;
            cursor: pointer;
        }

        ::placeholder {
            color: black;
            opacity: .4;
        }

        .modal-header {
            min-height: auto;
            padding: 15px;
            border-bottom: 1px solid #e5e5e5;
            height: 64px;
            text-align: center;
            font-weight: bold;
        }

        .modal-header22 {
            min-height: auto;
            padding: 15px 10px 0 10px;
            height: auto;
            text-align: center;
            font-weight: bold;
        }

        .modalbtnlink22 {
            width: calc(50% - 2px);
            padding: 20px;
            font-size: 14px;
            letter-spacing: .5px;
            text-align: center;
            font-weight: bold;
            color: #1D413F;
            display: inline-block;
            cursor: pointer;
        }

        .modalbtnlink22:last-child {
            width: calc(50% - 2px);
            border-left: 1px solid #9f8d7b;
        }

        .close {
            filter: alpha(opacity=100);
            opacity: 1;
        }

        .modal-title {
            margin: 0;
            line-height: 3.428571;
        }

        @media (min-width: 900px) {
            .modal-body {
                position: relative;
                padding: 30px 40px;
            }
        }

        .modal-content {
            border-radius: 0;
        }

        .sepetedit {
            display: inline-block;
            position: absolute;
            top: 15px;
            right: 14px;
            width: 16px;
            height: 19px;

            background-repeat: no-repeat;
            background-size: contain;
            cursor: pointer;
        }

        .btn {
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 0;
            font-size: 16px;
            font-weight: bold;
            letter-spacing: 1px;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -ms-touch-action: manipulation;
            touch-action: manipulation;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-image: none;
            border: 1px solid transparent;
            border-radius: 4px;
            height: 64px;
        }

        .adreZZ {
            border: 1px solid #FFFFFF;
            padding: 5px;
            border-radius: 6px;
        }

        .adresgereklidiv {
            border: 1px solid #FF5858;
            padding: 5px;
            border-radius: 6px;
        }

        #popmahal {
            font-size: 14px;
            background-color: #edf1f2;
            padding: 10px;
            margin-bottom: 7px;
        }

        #adresformdiv {
            max-width: 450px;
            margin: auto;
        }

        .yeniadresekle {
            font-size: 14px;
            font-weight: bold;
            color: #9C8D7D;
            cursor: pointer;
            padding: 5px;
            margin-top: 27px;
            background-size: 16px;
            background-repeat: no-repeat;
            background-position: center left;
            padding-left: 30px;
            float: left;
        }

        .locabackButton {
            display: none;
            padding: 15px 0;
            cursor: pointer;
        }

        .adreseklemedin {
            display: none;
            background-color: #FF5858;
            border-radius: 0 0 6px 6px;
            color: white;
            text-align: center;
            padding: 5px;
            font-size: 12px;
            width: 100%;
        }

        .sepettitleicon {
            text-align: center;
            margin-top: 30px;
            font-size: 0;
        }

        .sepettitleicon div {
            display: inline-block;
            width: 20%;
            max-width: 212px;
            cursor: pointer;
        }

        .sepettitleicon div img {
            width: 100%;
        }

        .sepettitleicon div:first-child {
            text-align: right;
        }

        .sepettitleicon div:last-child {
            text-align: left;
        }

        .sepettitleicon div:first-child img,
        .sepettitleicon div:last-child img {
            width: 56%;
        }

        .sepettitleicon div span {
            width: 100%;
            display: block;
            text-align: center;
            font-weight: bold;
            font-size: 12px;
            margin-top: 5px;
        }

        @media (max-width: 500px) {
            .sepettitleicon div span {
                font-size: 9px;
            }
        }

        .sepeteklebtn {
            background-color: #1d3435;
            border-radius: 6px;
            padding: 10px;
            cursor: pointer;
            display: inline-block;
            margin-top: 9px;
        }

        @media (max-width:768px) {
            .sepeteklebtn {
                background-color: #1d3435;
                border-radius: 6px;
                padding: 2px;
                cursor: pointer;
                display: inline-block;
                margin-top: 24px;
                margin-left: 0;
            }
        }

        .modal {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 1040;
            display: none;
            overflow: hidden;
            -webkit-overflow-scrolling: touch;
            outline: 0;
        }

        .modal.fade .modal-dialog {
            -webkit-transition: -webkit-transform .3s ease-out;
            -o-transition: -o-transform .3s ease-out;
            transition: transform .3s ease-out;
            -webkit-transform: translate(0, -25%);
            -ms-transform: translate(0, -25%);
            -o-transform: translate(0, -25%);
            transform: translate(0, -25%);
        }

        .modal-dialog {
            position: relative;
            width: auto;
            margin: 10px;
        }

        .modal-content {
            position: relative;
            background-color: #fff;
        }

        .modal-content22 {
            position: relative;
            background-color: #fff;
            padding: 12px;
        }

        .modal-content22-ic {
            position: relative;
            background-color: #fff;
            border: 1px solid #9f8d7b;
        }

        .modal-header .close {
            margin-top: -2px;
        }

        .modal-title {
            margin: 0;
            line-height: 1.42857143;
        }

        .modal-body22 {
            position: relative;
            padding: 15px;
            padding-bottom: 22px;
            text-align: center;
        }

        .modal-body {
            position: relative;
            padding: 15px;
            padding-bottom: 22px;
        }

        .modal-footer {
            padding: 0;
            border-top: 1px solid #9f8d7b;
        }

        @media (min-width:768px) {
            .modal-dialog {
                width: 600px;
                margin: 30px auto;
            }

            .modal-dialog22 {
                width: 500px;
                margin: 30px auto;
            }
        }



        /*! CSS Used from: Embedded */
        textarea {
            width: 95%;
            border: none;
            padding: 10px;
            border-radius: 5px;
            font-family: Courier New, Courier, monospace;
        }

        .kartbilgi2 {
            font-family: 'Kumbh Sans', sans-serif;
            margin-bottom: 20px;
        }

        .kartbilgi2 input[type=text],
        input[type=tel],
        textarea {
            width: 100%;
            border: none;
            border-bottom: 1px solid #e1dcd8;
            padding: 20px 10px;
            margin-bottom: 5px;
            font-size: 16px;
            font-family: 'Kumbh Sans', sans-serif;
        }

        .urunx {
            background-clip: border-box;
            background-color: white;
            box-sizing: border-box;
            color: rgb(0, 0, 0);
            display: flex;
            flex-wrap: wrap;
            font-family: 'Kumbh Sans';
            font-size: 16px;
            font-stretch: normal;
            font-style: normal;
            font-variant-caps: normal;
            font-variant-ligatures: normal;
            font-variant-numeric: normal;
            font-weight: lighter;
            line-height: normal;
            margin-bottom: 40px;
            position: relative;
            text-size-adjust: 100%;
            padding: 0;
        }

        #MainContent_sepet_sepet1_lstCart,
        #MainContent_sepet_sepet1_lstCart tr,
        #MainContent_sepet_sepet1_lstCart td,
        #MainContent_sepet_sepet1_lstCart th {
            border: none;
        }

        /*! CSS Used from: Embedded */
        @media (max-width: 480px) {
            .green.btn.sonrakibuton {
                position: fixed;
                bottom: 0px;
                left: 0px;
                width: 100%;
                border: 2px solid white;
                border-radius: 0;
                height: 70PX;
                font-size: 18px;
                font-weight: 600;
                letter-spacing: .8px;
            }
        }
        .delivery-address {
            border: 0px;
        }
        .address-medyanossa {
            font-size: 12px;
             line-height: 13px;
        }
        .header-style-1.header-height-2 { 
            display: none;
        }
        footer.main {
            display: none;
        }
        body {
            background-color: #f8f7f5;
        }
    </style>
</head>
    @if (Cart::instance('cart')->count() > 0)
        @php
        $products = get_products([
            'condition' => [
                ['ec_products.id', 'IN', Cart::instance('cart')->content()->pluck('id')->all()],
            ],
            'with' => ['slugable'],
        ]);
        @endphp
    @if (count($products))
<body>
    <div class="sepetmain">
        <div class="container">
            <div class=" margin-bottom-40">
                <div class="sepettitleicon">
                    <div>
                        <img src="https://www.ribbonflowers.com/ikonlar/sepet1_aktif.png?v=1">
                        <br>
                        <span>{{ __('Delivery') }}</span>
                    </div>
                    <div>
                        <img src="https://www.ribbonflowers.com/ikonlar/sepet2.png">
                        <br>
                        <span>{{ __('Additional Gifts') }}</span>
                    </div>
                    <div>
                        <img src="https://www.ribbonflowers.com/ikonlar/sepet3.png">
                        <br>
                        <span>{{ __('Message Card') }}</span>
                    </div>
                    <div>
                        <img src="https://www.ribbonflowers.com/ikonlar/sepet4.png">
                        <br>
                        <span>{{ __('Invoice') }}</span>
                    </div>
                    <div>
                        <img src="https://www.ribbonflowers.com/ikonlar/sepet5.png">
                        <br>
                        <span>{{ __('Payment') }}</span>
                    </div>
                </div>
                <div>
                    <div class="clearfix">
                        <div class="table-wrapper-responsive" style="margin-top:50px">
                            <div class="SEPETSOL">
                                <div>
                                    <table>
                                        <tbody>
                                            <tr>
                                                <th class="delivery-address" scope="col">
                                                    <span class="sepettitle" style="text-align:center;">{{ __('Delivery address') }}</span>
                                                </th>
                                            </tr>
                                            @foreach(Cart::instance('cart')->content() as $key => $cartItem)
                                                @php
                                                    $product = $products->find($cartItem->id);
                                                @endphp
                                            <tr>
                                                @if(session('success'))
                                                    <div class="alert alert-success">
                                                        {{ session('success') }}
                                                    </div>
                                                @endif
                                                <td>
                                                    <div class="">
                                                        <div class="container">
                                                            <div class="row align-items-center">
                                                                <div class="col col-lg-2">
                                                                    <a href="{{ $product->original_product->url }}"><img alt="{{ $product->original_product->name }}" src="{{ RvMedia::getImageUrl($cartItem->options['image'], 'thumb', false, RvMedia::getDefaultImage()) }}" style="margin-right:15px;max-width:100%;width: 100%;border-radius: 5px;"></a>
                                                                </div>
                                                                <div class="col-7">
                                                                    <span class="sepeturuntitle"><a href="{{ $product->original_product->url }}">{{ $product->original_product->name }}  @if ($product->isOutOfStock()) <span class="stock-status-label">({!! $product->stock_status_html !!})</span> @endif</a></span>
                                                                    <p class="address-medyanossa">
                                                                        @if (!empty($cartItem->options['options']))
                                                                        {!! render_product_options_info($cartItem->options['options'], $product, true) !!}
                                                                        @endif
                                                                    </p> 
                                                                </div>
                                                                <div class="col col-lg-2">
                                                                    <span><span class="d-inline-block">{{ format_price($cartItem->price) }}</span> @if ($product->front_sale_price != $product->price)
                                                                    <small><del>{{ format_price($product->price) }}</del></small>@endif</h3>
                                                                </div>
                                                                <div class="col col-lg-1">
                                                                    <a href="#" class="text-body remove-cart-button" data-url="{{ route('public.ajax.cart.destroy', $cartItem->rowId) }}"><i class="fi-rs-trash"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="adreseklebtn2">
                                                        <b style="padding-right:20px;">Teslimat:</b>
                                                        
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>   
                                </div>
                                <center>
                                    <a href="/products">
                                        <u>{{ __('Back to Shopping') }}</u>
                                    </a>
                                </center>
                            </div>
                        </div>
                        <div class="SEPETSAG">
                            <div class="sepetozetrow">
                                <div class="ozetic" style="position: relative;">
                                    <div class="position-relative" id="cart-item">
                                        <div class="payment-info-loading" style="display: none;">
                                            <div class="payment-info-loading-content">
                                                <i class="fas fa-spinner fa-spin"></i>
                                            </div>
                                        </div>
                                        <span class="sepettitle" style="text-align:center;">{{ __('Order Summary') }}</span><hr>
                                            <div class="row">
                                                <div class="col-6">
                                                    <p>{{ __('Subtotal') }}:</p>
                                                </div>
                                                <div class="col-6">
                                                    <p class="price-text sub-total-text text-end">
                                                        {{ format_price(Cart::instance('cart')->rawSubTotal()) }}
                                                    </p>
                                                </div>
                                            </div>
                                        @if (EcommerceHelper::isTaxEnabled())
                                            <div class="row">
                                                <div class="col-6">
                                                    <p>{{ __('Tax') }}:</p>
                                                </div>
                                                <div class="col-6 float-end">
                                                    <p class="price-text tax-price-text">
                                                        {{ format_price(Cart::instance('cart')->rawTax()) }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endif @if (session('applied_coupon_code'))
                                            <div class="row coupon-information">
                                                <div class="col-6">
                                                    <p>{{ __('Coupon code') }}:</p>
                                                </div>
                                                <div class="col-6">
                                                    <p class="price-text coupon-code-text">
                                                        {{ session('applied_coupon_code') }} </p>
                                                </div>
                                            </div>
                                        @endif @if ($couponDiscountAmount > 0)
                                            <div class="row price discount-amount">
                                                <div class="col-6">
                                                    <p>{{ __('Coupon code discount amount') }}:</p>
                                                </div>
                                                <div class="col-6">
                                                    <p class="price-text total-discount-amount-text">
                                                        {{ format_price($couponDiscountAmount) }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endif @if ($promotionDiscountAmount > 0)
                                            <div class="row">
                                                <div class="col-6">
                                                    <p>{{ __('Promotion discount amount') }}:</p>
                                                </div>
                                                <div class="col-6">
                                                    <p class="price-text">
                                                        {{ format_price($promotionDiscountAmount) }} </p>
                                                </div>
                                            </div>
                                        @endif @if (!empty($shipping) && Arr::get($sessionCheckoutData, 'is_available_shipping', true))
                                            <div class="row">
                                                <div class="col-6">
                                                    <p>{{ __('Shipping fee') }}:</p>
                                                </div>
                                                <div class="col-6 float-end">
                                                    <p class="price-text shipping-price-text">
                                                        {{ format_price($shippingAmount) }}</p>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-6">
                                                <p>
                                                    <strong>{{ __('Shipping fee') }}</strong>:
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="mt-3 mb-5"> @include('plugins/ecommerce::themes.discounts.partials.form') </div>
                                <hr>
                                <a href="/additionalgifts" class="btn green sonrakibuton">{{ __('Continue') }}</a>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endif
@else
<div class="container" style="height: 350px;">
    <div class="row row justify-content-md-center">
        <div class="col-md-auto">
            <h3>{{ __('No products in the cart.') }}</h3>
        </div>
        
    </div>
    
    <div class="row row justify-content-md-center">
        <div class="col-md-auto margin-50">
            <a class="btn btn-primary" style="padding: 20px;" href="{{ route('public.products') }}" role="button">{{ __('Start shopping') }}</a>
        </div>
    </div>
    
</div>
@endif
