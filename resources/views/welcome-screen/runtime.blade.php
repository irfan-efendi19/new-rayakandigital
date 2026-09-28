<script type="application/json" id="welcome-screen-data">{!! json_encode($screenData, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
<script src="{{ asset('welcome-screen/modules.js') }}" defer></script>
<script src="{{ asset('welcome-screen/app.js') }}" defer></script>
