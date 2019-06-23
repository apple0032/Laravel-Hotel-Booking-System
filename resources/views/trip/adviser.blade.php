@php
    use App\TripAdviser;
@endphp

@extends('index')

@section('title', '| Trip')

@section('content')
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400&display=swap" rel="stylesheet">
    <style type="text/css" class="cp-pen-styles">

        * {
            box-sizing: border-box
        }

        .clearfix:before, body:before {
            content: '';
            display: table
        }

        .clearfix:after, body:after {
            clear: both;
            content: '';
            display: table
        }

        .ellipsis {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap
        }

        article, aside, details, figcaption, figure, footer, header, hgroup, nav, section {
            display: block
        }

        audio, canvas, video {
            display: inline-block
        }

        audio:not([controls]) {
            display: none
        }

        html {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%
        }

        body {
            line-height: 18px;
            margin: 0;
            min-width: 320px;
            padding: 0;
            position: relative;
            text-align: left
        }

        body, button, input, select, textarea {
            color: #717171;
            font-family: Raleway, sans-serif;
            font-size: 13px
        }

        ::-moz-selection {
            background: #3197fc;
            color: #fff;
            text-shadow: none
        }

        ::selection {
            background: #3197fc;
            color: #fff;
            text-shadow: none
        }

        a:active, a:hover {
            outline: 0
        }

        abbr, acronym {
            border-bottom: 1px dotted;
            cursor: help
        }

        .is-mobile abbr, .is-mobile acronym {
            border: 0
        }

        b, strong {
            font-weight: 700
        }

        address {
            font-style: normal;
            margin-bottom: 18px
        }

        blockquote {
            margin: 18px 40px
        }

        dfn {
            font-style: italic
        }

        hr {
            border: 0;
            border-bottom: 1px dotted #ccc;
            display: block;
            height: 0;
            margin: 0;
            padding: 0
        }

        ins {
            color: #000;
            text-decoration: none;
            margin-bottom: 18px !important
        }

        ins ins {
            margin-bottom: 0 !important
        }

        mark {
            background: #ff0;
            color: #000;
            font-style: italic;
            font-weight: 700
        }

        code, kbd, pre, samp {
            font-family: monospace, serif;
            font-size: 1em
        }

        pre {
            white-space: pre;
            white-space: pre-wrap;
            word-wrap: break-word
        }

        q {
            quotes: none
        }

        q:after, q:before {
            content: '';
            content: none
        }

        small {
            font-size: 85%
        }

        sub, sup {
            font-size: 75%;
            line-height: 0;
            position: relative;
            vertical-align: baseline
        }

        sup {
            top: -.5em
        }

        sub {
            bottom: -.25em
        }

        ol, ul {
            margin: 0 0 18px 0;
            padding: 0 0 0 25px
        }

        dd {
            margin: 0 0 0 25px
        }

        .nav ol, .nav ul {
            list-style: none;
            list-style-image: none;
            margin: 0;
            padding: 0
        }

        img {
            border: 0;
            -ms-interpolation-mode: bicubic;
            vertical-align: top
        }

        svg:not(:root) {
            overflow: hidden;
            pointer-events: none
        }

        figure {
            margin: 0
        }

        form {
            margin: 0
        }

        fieldset {
            border: 0;
            margin: 0;
            padding: 0
        }

        label {
            cursor: pointer
        }

        legend {
            border: 0;
            padding: 0
        }

        button, input, select, textarea {
            font-size: 100%;
            margin: 0;
            vertical-align: middle
        }

        button, input {
            line-height: normal
        }

        button, input[type=button], input[type=reset], input[type=submit] {
            cursor: pointer;
            -webkit-appearance: button
        }

        input[type=checkbox], input[type=radio] {
            box-sizing: border-box;
            padding: 0;
            position: relative;
            top: -1px;
            vertical-align: middle
        }

        input[type=checkbox]:focus, input[type=radio]:focus {
            outline-width: 5px
        }

        input[type=search] {
            -webkit-appearance: textfield;
            box-sizing: content-box
        }

        input[type=search]::-webkit-search-decoration {
            -webkit-appearance: none
        }

        button::-moz-focus-inner, input::-moz-focus-inner {
            border: 0;
            padding: 0
        }

        textarea {
            overflow: auto;
            vertical-align: top;
            resize: vertical
        }

        table {
            border-collapse: collapse;
            border-spacing: 0
        }

        td {
            vertical-align: top
        }

        :focus {
            outline-width: 0
        }

        .clear {
            clear: both
        }

        .hidden, .ng-cloak, .ng-hide, .print, .x-ng-cloak, [data-ng-cloak], [ng-cloak], [ng\:cloak], [x-ng-cloak] {
            display: none !important;
            visibility: hidden
        }

        [class*=js-dnd-] {
            cursor: -webkit-grab !important;
            cursor: grab !important;
            z-index: 1
        }

        svg {
            display: inline-block;
            fill: #717171;
            vertical-align: middle
        }

        .sans-serif {
            font-family: sans-serif !important
        }

        .external-link {
            position: relative
        }

        .external-link svg {
            height: 12px;
            width: 12px;
            margin: -5px 0 0;
            position: absolute;
            right: 4px;
            top: 50%
        }

        .left {
            float: left
        }

        .right {
            float: right
        }

        .center {
            margin: 0 auto
        }

        .text-left {
            text-align: left !important
        }

        .text-right {
            text-align: right !important
        }

        .text-center {
            text-align: center !important
        }

        .nowrap {
            white-space: nowrap
        }

        .overflow-hidden {
            overflow: hidden !important
        }

        .relative {
            position: relative
        }

        .clickable {
            cursor: pointer
        }

        .uppercase {
            text-transform: uppercase
        }

        .small-screen {
            display: none
        }

        @media screen and (max-width: 767px) {
            .small-screen {
                display: block
            }
        }

        .small-screen-inline {
            display: none
        }

        @media screen and (max-width: 767px) {
            .small-screen-inline {
                display: inline
            }
        }

        @media screen and (max-width: 767px) {
            .not-small-screen {
                display: none !important
            }
        }

        .medium-screen {
            display: none
        }

        @media screen and (max-width: 1024px) {
            .medium-screen {
                display: block
            }
        }

        .medium-screen-inline {
            display: none
        }

        @media screen and (max-width: 1024px) {
            .medium-screen-inline {
                display: inline
            }
        }

        @media screen and (max-width: 1024px) {
            .not-medium-screen {
                display: none !important
            }
        }

        img {
            user-drag: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none
        }

        .small-container {
            margin: auto;
            max-width: 980px;
            padding: 0 20px
        }

        .container {
            margin-left: 8%;
            margin-right: 8%;
            padding: 0 20px
        }

        .container.relative {
            position: relative
        }

        .subheader {
            border-bottom: 1px solid #e8e8e8;
            margin-top: 95px
        }

        .subheader h1 {
            color: #303030;
            font-family: "Playfair Display", serif;
            font-size: 48px;
            font-weight: 100;
            text-align: center
        }

        .button-round {
            background-color: #0583ff;
            border: 0;
            border-radius: 33px;
            color: #fff;
            font-family: Raleway, sans-serif;
            font-size: 16px;
            font-weight: 500;
            line-height: 32px;
            padding-bottom: 15px;
            padding-left: 15px;
            padding-right: 15px;
            padding-top: 15px;
            text-decoration: none;
            text-transform: uppercase
        }

        .button-round:focus, .button-round:hover {
            background-color: #0069d1
        }

        @media screen and (max-width: 500px) {
            .container {
                margin-left: 0;
                margin-right: 0
            }
        }

        .lang-selector {
            position: relative
        }

        .lang-selector .flag {
            cursor: pointer
        }

        .lang-popup {
            background: #fff;
            border-radius: 2px;
            box-shadow: 0 0 6px rgba(0, 0, 0, .4);
            display: none;
            font-size: 13px;
            line-height: 20px;
            list-style-type: none;
            padding: 10px 0;
            position: absolute;
            right: 0;
            text-align: left;
            width: 380px
        }

        .lang-popup a {
            color: #1d1d1d;
            display: block;
            float: left;
            overflow: hidden;
            padding: 13px 20px;
            position: relative;
            text-decoration: none;
            white-space: nowrap;
            width: 50%
        }

        .lang-popup a:focus, .lang-popup a:hover {
            background-color: #ececec
        }

        .lang-popup svg {
            fill: #70b75a;
            height: 14px;
            margin: -4px 0 0 5px;
            width: 14px
        }

        .lang-popup:after, .lang-popup:before {
            background: #fff;
            bottom: 100%;
            content: '';
            height: 6px;
            margin-bottom: -5px;
            padding: 1px;
            position: absolute;
            right: 20px;
            transform: rotate(45deg);
            width: 6px;
            z-index: 1
        }

        .lang-popup:after {
            box-shadow: 0 0 6px rgba(0, 0, 0, .4);
            z-index: -1
        }

        @media screen and (max-width: 400px) {
            .lang-popup {
                font-size: 11px;
                width: 300px
            }
        }

        .flag {
            background-size: 32px 21px;
            display: inline-block;
            height: 21px;
            margin-right: 8px;
            vertical-align: middle;
            width: 32px
        }

        .flag-cs-cz {
            background-image: url(../img/lang/cs-cz.png)
        }

        .flag-de-de {
            background-image: url(../img/lang/de-de.png)
        }

        .flag-en-gb {
            background-image: url(../img/lang/en-gb.png)
        }

        .flag-en-us {
            background-image: url(../img/lang/en-us.png)
        }

        .flag-es-es {
            background-image: url(../img/lang/es-es.png)
        }

        .flag-fr-fr {
            background-image: url(../img/lang/fr-fr.png)
        }

        .flag-hu-hu {
            background-image: url(../img/lang/hu-hu.png)
        }

        .flag-it-it {
            background-image: url(../img/lang/it-it.png)
        }

        .flag-ko-kr {
            background-image: url(../img/lang/ko-kr.png)
        }

        .flag-nl-nl {
            background-image: url(../img/lang/nl-nl.png)
        }

        .flag-pl-pl {
            background-image: url(../img/lang/pl-pl.png)
        }

        .flag-pt-br {
            background-image: url(../img/lang/pt-br.png)
        }

        .flag-ru-ru {
            background-image: url(../img/lang/ru-ru.png)
        }

        .flag-sk-sk {
            background-image: url(../img/lang/sk-sk.png)
        }

        .flag-tr-tr {
            background-image: url(../img/lang/tr-tr.png)
        }

        .flag-zh-cn {
            background-image: url(../img/lang/zh-cn.png)
        }

        .header {
            background: #fff;
            border-bottom: 1px solid #e8e8e8;
            font-size: 18px;
            line-height: 50px;
            min-width: 320px;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 9998
        }

        .header .logo {
            height: 34px;
            width: 140px;
            margin-top: 8px
        }

        .header .container {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-pack: justify;
            justify-content: space-between;
            margin: auto;
            padding: 0 10px
        }

        .map a {
            display: block;
            height: 100%;
            position: relative;
            transition: all .2s ease-in-out
        }

        .map a:focus, .map a:hover {
            box-shadow: 0 0 68px #ddd
        }

        .map iframe {
            border: 0;
            display: block;
            height: 100%;
            width: 100%
        }

        .map .map-overlay {
            height: 100%;
            padding-right: 40px;
            position: absolute;
            width: 100%
        }

        .try-app-container {
            -ms-flex-align: center;
            align-items: center;
            background-image: url(../img/background-hills.png);
            background-position: center bottom;
            background-repeat: no-repeat;
            background-size: 1930px;
            border-bottom: 1px solid #e8e8e8;
            border-top: 1px solid #e8e8e8;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column
        }

        .try-app-header {
            -ms-flex-align: center;
            align-items: center;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column
        }

        .try-app-header > h2 {
            color: #303030;
            font-family: "Playfair Display", serif;
            font-size: 44px;
            font-weight: 400;
            line-height: 35px;
            margin-bottom: 35px;
            margin-top: 50px
        }

        .try-app-header > span {
            font-family: Raleway, sans-serif;
            font-size: 20px;
            font-weight: 400;
            line-height: 30px;
            margin-bottom: 60px
        }

        .try-app-content {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-flow: row wrap;
            flex-flow: row wrap;
            -ms-flex-pack: center;
            justify-content: center
        }

        .try-app-phone {
            background-image: url(../img/phone.png);
            background-repeat: no-repeat;
            background-size: 379px 778px;
            height: 584px;
            width: 472px
        }

        .try-app-info > :nth-child(1) {
            margin-bottom: 25px
        }

        .try-app-info > :nth-child(2) {
            color: #303030;
            font-family: Raleway, sans-serif;
            font-size: 20px;
            font-weight: 500;
            line-height: 30px;
            margin-bottom: 20px;
            max-width: 481px
        }

        .try-app-info > :nth-child(3) {
            margin-bottom: 40px
        }

        .try-app-info .badges-container {
            display: -ms-flexbox;
            display: flex
        }

        .try-app-info .google-badge {
            float: left;
            margin-left: -15px
        }

        .try-app-info .google-badge img {
            height: 80px
        }

        .try-app-info .ios-badge a {
            background-size: 185px !important;
            height: 54px !important;
            margin-top: 13px;
            width: 184px !important
        }

        @media screen and (max-width: 1220px) {
            .try-app-phone {
                background-position-x: 50%;
                -ms-flex-order: 2;
                order: 2;
                width: 100%
            }

            .try-app-info {
                margin-bottom: 50px;
                -ms-flex-order: 1;
                order: 1;
                width: 100%
            }
        }

        @media screen and (max-width: 500px) {
            .try-app-phone {
                display: none
            }

            .badges-container {
                -ms-flex-align: center;
                align-items: center;
                -ms-flex-direction: column;
                flex-direction: column
            }

            .ios-badge {
                padding-right: 16px
            }

            .try-app-container {
                background-image: none
            }

            .try-app-header > :nth-child(1) {
                font-size: 30px;
                margin-top: 25px
            }

            .try-app-header > :nth-child(2) {
                font-size: 18px;
                margin-bottom: 30px
            }

            .try-app-info {
                margin-bottom: 0
            }

            .try-app-info > :nth-child(2) {
                display: none
            }

            .try-app-info > :nth-child(3) {
                display: none
            }

            .try-app-info > :nth-child(4) {
                display: none
            }
        }

        .sms-input-container {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-flow: row wrap;
            flex-flow: row wrap;
            -ms-flex-pack: justify;
            justify-content: space-between
        }

        .phone-input {
            background-color: #eaeaea;
            border: 0;
            border-radius: 6px;
            color: #303030;
            font-family: Raleway;
            font-size: 20px;
            font-weight: 500;
            height: 63px;
            line-height: 32px;
            padding-left: 30px;
            padding-right: 30px;
            width: 70%
        }

        .phone-send-button {
            height: 63px;
            letter-spacing: 2px;
            width: 25%
        }

        .phone-send-button.sent {
            background-color: #2eb82e
        }

        .phone-send-button span.sent {
            display: none
        }

        @media screen and (max-width: 870px) {
            .phone-input {
                margin-bottom: 15px;
                width: 100%
            }

            .phone-send-button {
                margin: 0 auto;
                width: 100%
            }
        }

        .spinner {
            animation: sk-scaleout 1s infinite ease-in-out;
            background-color: #fff;
            border-radius: 100%;
            display: none;
            height: 50px;
            margin: 0 auto;
            width: 50px
        }

        @keyframes sk-scaleout {
            0% {
                transform: scale(0)
            }
            100% {
                opacity: 0;
                transform: scale(1)
            }
        }

        .related {
            text-align: center
        }

        .related h2 {
            color: #303030;
            font-family: "Playfair Display", serif;
            font-size: 48px;
            font-weight: 400;
            line-height: 60px;
            margin-bottom: 50px;
            margin-top: 60px
        }

        .related span {
            display: block;
            padding-left: 20%;
            text-align: left
        }

        .related span a {
            color: #717171;
            font-family: Raleway, sans-serif;
            font-size: 18px;
            font-weight: 400;
            line-height: 36px
        }

        .related span a:focus, .related span a:hover {
            text-decoration: underline
        }

        .related .masonry {
            -moz-column-count: 4;
            column-count: 4;
            padding-bottom: 100px
        }

        @media screen and (max-width: 1500px) {
            .related span a {
                font-size: 14px
            }
        }

        @media screen and (max-width: 1220px) {
            .related .masonry {
                -moz-column-count: 3;
                column-count: 3
            }
        }

        @media screen and (max-width: 870px) {
            .related .masonry {
                -moz-column-count: 2;
                column-count: 2
            }
        }

        @media screen and (max-width: 500px) {
            .related h2 {
                font-size: 25px;
                margin-bottom: 0;
                margin-top: 0;
                text-align: left
            }

            .related span {
                padding-left: 0
            }

            .related span a {
                font-size: 15px
            }

            .related .masonry {
                -moz-column-count: 1;
                column-count: 1
            }
        }

        .footer {
            background: #fbfbfb;
            border-top: 1px solid #e8e8e8;
            font-family: Raleway, sans-serif;
            font-size: 13px;
            padding: 30px 0;
            position: relative;
            text-align: center;
            z-index: 10
        }

        .footer-menu {
            margin: 0;
            padding: 0 0 20px
        }

        .footer-menu li {
            display: inline-block
        }

        .footer-menu a {
            color: #717171;
            padding: 0 5px;
            text-decoration: none;
            text-transform: uppercase
        }

        .share {
            list-style-type: none;
            margin: 0 0 20px;
            padding: 0
        }

        .share li {
            display: inline-block;
            padding: 0 7px
        }

        .share a {
            background-color: #adadad;
            border-radius: 25px;
            display: block;
            padding: 10px
        }

        .share svg {
            fill: #fbfbfb;
            height: 30px;
            width: 30px
        }

        .share .facebook:hover {
            background-color: #466bc9
        }

        .share .twitter:hover {
            background-color: #3daff0
        }

        .share .pinterest:hover {
            background-color: #cc2127
        }

        .share .instagram:hover {
            background-color: #824eb6
        }

        .small-container a {
            word-wrap: break-word
        }

        .page-title {
            line-height: 50px
        }

        .page-description {
            font-size: 22px;
            text-align: center
        }

        .place-description {
            color: #717171;
            font-size: 16px;
            line-height: 26px;
            padding: 0 35px
        }

        .place-description.attribution {
            margin-bottom: 10px
        }

        .place-photo {
            display: block;
            position: relative
        }

        .place-photo .photo-attribution {
            background: rgba(0, 0, 0, .6);
            bottom: 0;
            color: #fff;
            line-height: 18px;
            padding: 0 8px 0 5px;
            position: absolute;
            right: 0;
            display: none;
        }

        .place-photo .photo-attribution a {
            color: #fff;
            cursor: pointer;
            text-decoration: underline
        }

        .place-photo > a {
            display: block
        }

        .place-list {
            background: #fbfbfb;
            border-bottom: 1px solid #e8e8e8
        }

        .open-map {
            padding: 0 35px
        }

        .open-map a {
            color: #0583ff;
            float: right;
            font-size: 16px
        }

        .map-list iframe {
            height: 500px
        }

        .description-attribution {
            margin-bottom: 30px;
            padding: 0 35px
        }

        .description-attribution a {
            color: #717171;
            font-size: 13px;
            font-style: italic;
            text-decoration: none;
            text-transform: capitalize
        }

        .description-attribution a:focus, .description-attribution a:hover {
            text-decoration: underline
        }

        .masonry {
            -moz-column-count: 4;
            column-count: 4;
            margin: 0;
            padding: 0 0 40px;
            text-align: center;
            transform: translateZ(0)
        }

        .masonry li {
            break-inside: avoid-column;
            -webkit-column-break-inside: avoid;
            display: inline-block;
            list-style-type: none;
            margin-top: 15px;
            padding-bottom: 15px;
            padding-left: 15px;
            padding-right: 15px;
            padding-top: 10px;
            page-break-inside: avoid;
            position: relative;
            text-align: left;
            width: 100%
        }

        .masonry li img {
            background-color: #f1f3ed;
            border-radius: 10px 10px 0 0;
            height: auto;
            transform: translateZ(0);
            width: 100%
        }

        .masonry .empty-image {
            background-color: #eee;
            display: block;
            height: 254px
        }

        .masonry .image-placeholder {
            display: -ms-flexbox;
            display: flex;
            height: 100%;
            -ms-flex-pack: center;
            justify-content: center;
            width: 100%
        }

        .masonry .image-placeholder svg {
            fill: #c5c5c5;
            width: 25%
        }

        .masonry .inner-list {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 10px 20px #eee;
            overflow: hidden;
            padding-bottom: 20px;
            transition: box-shadow .2s ease
        }

        .masonry .inner-list.ad {
            overflow: visible;
            padding-top: 40px
        }

        .masonry .inner-list a {
            cursor: pointer
        }

        .masonry h3 {
            margin-top: 30px
        }

        .masonry h3 a {
            color: #303030;
            cursor: pointer;
            display: inline-block;
            font-family: "Playfair Display", serif;
            font-size: 25px;
            line-height: 30px;
            padding: 0 35px;
            text-decoration: none
        }

        .masonry h3 a:focus, .masonry h3 a:hover {
            text-decoration: underline
        }

        @media screen and (max-width: 1450px) {
            .masonry {
                -moz-column-count: 3;
                column-count: 3
            }
        }

        @media screen and (max-width: 1220px) {
            .masonry {
                -moz-column-count: 2;
                column-count: 2
            }
        }

        @media screen and (max-width: 835px) {
            .masonry {
                -moz-column-count: 1;
                column-count: 1
            }
        }

        .hotel .star-rating {
            margin-top: 20px;
            padding: 0 35px
        }

        .hotel .star-rating svg {
            fill: #fbb818;
            width: 12px
        }

        .hotel .star-rating span {
            color: #fbb818
        }

        .hotel h3 {
            margin-top: 5px
        }

        .hotel .hotel-controls {
            padding: 0 35px
        }

        .hotel .hotel-controls .button-round {
            cursor: pointer;
            display: inline-block;
            letter-spacing: 2px;
            line-height: normal;
            text-align: center;
            width: 100%
        }

        .hotel .hotel-controls .hotel-price {
            font-size: 16px;
            margin: 15px 0;
            text-align: right
        }

        .hotel .hotel-controls .hotel-price .price {
            color: #0583ff
        }

        .hotel .hotel-controls .booking-attribution {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-pack: justify;
            justify-content: space-between
        }

        .hotel .hotel-controls .booking-rating {
            -ms-flex-align: center;
            align-items: center;
            display: -ms-flexbox;
            display: flex
        }

        .hotel .hotel-controls .booking-rating > :nth-child(1) {
            background: #092a82;
            border-radius: 15% 15% 15% 0;
            color: #fff;
            font-family: sans-serif;
            height: 30px;
            line-height: 30px;
            text-align: center;
            width: 30px
        }

        .hotel .hotel-controls .booking-rating > :nth-child(2) {
            padding-left: 7px
        }

        .hotel .hotel-controls .booking-logo {
            background-image: url(../img/booking.png);
            background-position: center;
            background-repeat: no-repeat;
            background-size: contain;
            width: 100px
        }

        .hotel .hotel-controls .rating-info {
            color: #092a82;
            font-weight: 700
        }

        @media screen and (max-width: 500px) {
            .subheader {
                margin-bottom: 0;
                margin-top: 80px
            }

            .subheader .page-title {
                font-size: 28px;
                text-align: left
            }

            .items li {
                padding-left: 0;
                padding-right: 0
            }
        }

        @supports not (flex-wrap:wrap) {
            .masonry {
                display: block
            }

            .masonry li {
                display: inline-block;
                vertical-align: top
            }
        }

        .raise {
            transition: all .3s ease-out
        }

        .raise:focus .inner-list, .raise:hover .inner-list {
            box-shadow: 0 10px 20px #ccc
        }

        .is-ios .hide-on-ios {
            display: none
        }

        .is-android .hide-on-android {
            display: none
        }

        .mobile-banner {
            background: #fff;
            bottom: 0;
            box-shadow: 0 -1px 0 #ccc;
            display: none;
            left: 0;
            padding: 15px;
            position: fixed;
            width: 100%;
            z-index: 100
        }

        .mobile-banner-shown {
            display: block
        }

        .mobile-banner-info {
            background: url(../img/sygic-maps-icon.png) no-repeat left center;
            background-size: 40px;
            color: #000;
            font-size: 12px;
            line-height: 20px;
            margin-bottom: 20px;
            padding-left: 55px
        }

        .mobile-banner-info b {
            display: block;
            font-size: 15px;
            font-weight: 400
        }

        .mobile-banner-actions {
            -ms-flex-align: center;
            align-items: center;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: row-reverse;
            flex-direction: row-reverse
        }

        .mobile-banner-link {
            color: #0583ff;
            text-decoration: underline
        }

        .mobile-banner-link:active, .mobile-banner-link:focus, .mobile-banner-link:hover {
            color: #0069d1;
            text-decoration: none
        }

        .mobile-banner-button {
            background: #0583ff;
            border: 0;
            border-radius: 3px;
            color: #fff;
            cursor: pointer;
            display: inline-block;
            line-height: 38px;
            margin-left: 20px;
            padding: 2px 20px 0;
            position: relative;
            text-align: center;
            text-decoration: none;
            text-transform: uppercase;
            transition: padding .2s ease;
            vertical-align: middle;
            white-space: nowrap
        }

        .mobile-banner-button:focus, .mobile-banner-button:hover {
            background: #0069d1;
            color: #fff
        }

        .container_adviser {
            margin-top: 25px;
            margin-left: 8%;
            margin-right: 8%;
            padding: 0 20px;
        }

        body {
            background-image: url('') !important;
            background: #f2f2f2;
        }

        .place_name{
            font-size: 35px;
            margin-top: 20px;
            color: #585858;
            font-family: 'Quicksand', sans-serif;
        }

        .country_flag{
            text-align: right;
        }

        .place-address{
            padding-left: 35px;
            padding-right: 35px;
        }

        .address{
            margin-left: 10px;
            font-size: 10px;
        }
    </style>

    <div class="container_adviser">
        <div class="adviser_header row">
            <div class="col-md-6 place_name">
                {{$city->name}} - {{$country}}
            </div>
            <div class="col-md-6 country_flag">
                <img src="https://countryflags.io/{{$country_code}}/flat/64.png">
            </div>
        </div>

        <ul class="masonry items">
            @foreach($data as $poi)
                <li class="raise">
                <div class="inner-list">
                    <div class="place-photo">
                        <a href="#" alt="Science Museum image">
                            @php
                                $img = TripAdviser::getPlaceCoverImage($poi['main_media']['media'][0]['url_template'], '380x254');
                            @endphp
                            <img src="{{$img}}">
                        </a>
                    </div>
                    <h3><a href="#">{{$poi['name']}}</a></h3>
                    <p class="place-description">{{$poi['perex']}}</p>
                    <br>
                    @if($poi['address'] != null)
                        <div class="place-address row">
                            <i class="fas fa-map-marker-alt"></i>
                            <span class="address"> {{$poi['address']}}</span>
                        </div>
                    @endif
                </div>
            </li>
            @endforeach
        </ul>
    </div>


@endsection

@section('scripts')

@endsection