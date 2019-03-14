@extends('index')

@section('title', '| Trip')

@section('content')
<style>

</style>

<meta name="csrf-token" content="{{ csrf_token() }}"/>

        <div class="trip_container">
<!--            <pre class="brush: php">
                function getDatesFromRange($start, $end, $format = 'Y-m-d') {
                    $array = array();
                    $interval = new DateInterval('P1D');

                    $realEnd = new DateTime($end);
                    $realEnd->add($interval);

                    $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

                    foreach($period as $date) { 
                        $array[] = $date->format($format); 
                    }

                    return $array;
                }
            </pre>-->
        </div>

@endsection

@section('scripts')
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<link href="http://alexgorbatchev.com/pub/sh/current/styles/shThemeDefault.css" rel="stylesheet" type="text/css" />
<script src="http://alexgorbatchev.com/pub/sh/current/scripts/shCore.js" type="text/javascript"></script>
<script src="http://alexgorbatchev.com/pub/sh/current/scripts/shAutoloader.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/scripts/shBrushPhp.js"></script>
<script type="text/javascript">
     SyntaxHighlighter.all()
</script>
@endsection