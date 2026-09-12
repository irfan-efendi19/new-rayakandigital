<div class="bp-principal-card" data-aos="fade-up">
    <!-- Corner Crosshairs -->
    <div class="bp-corner-cross bp-corner-tl"></div>
    <div class="bp-corner-cross bp-corner-tr"></div>
    <div class="bp-corner-cross bp-corner-bl"></div>
    <div class="bp-corner-cross bp-corner-br"></div>

    <div class="bp-principal-card-header">
        <span>PRIN-01 // THE GROOM</span>
        <span class="bp-stamp-cyan-pill">LEAD ARCHITECT</span>
    </div>

    <div class="bp-principal-photo-wrap">
        <img src="{{ $groomPhotoUrl }}" alt="{{ $invitation->groom_name }}">
        <div style="font-size: 8px; color: var(--bp-line-cyan); letter-spacing: 1px; text-transform: uppercase; margin-top: 4px; text-align: center;">
            FIG 02.1 PRINCIPAL 01 PROFILE
        </div>
    </div>

    <h3 class="bp-principal-name">{{ $invitation->groom_name }}</h3>
    <div class="bp-principal-role">
        @if($invitation->groom_nickname)
            "{{ $invitation->groom_nickname }}" · 
        @endif
        Perencana Struktur &amp; Konstruksi
    </div>

    <div class="bp-principal-specs">
        @if($invitation->groom_father_name || $invitation->groom_mother_name)
            <div class="bp-spec-row">
                <span class="bp-spec-label">Ayah:</span>
                <span class="bp-spec-value">{{ $invitation->groom_father_name }}</span>
            </div>
            <div class="bp-spec-row">
                <span class="bp-spec-label">Ibu:</span>
                <span class="bp-spec-value">{{ $invitation->groom_mother_name }}</span>
            </div>
        @elseif($invitation->groom_parents)
            <div class="bp-spec-row">
                <span class="bp-spec-label">Putra Dari:</span>
                <span class="bp-spec-value">{{ $invitation->groom_parents }}</span>
            </div>
        @else
            <div class="bp-spec-row">
                <span class="bp-spec-label">Putra Dari:</span>
                <span class="bp-spec-value">Keluarga Besar Bpk. &amp; Ibu Suryanegara</span>
            </div>
        @endif

        @if($invitation->groom_instagram)
            <div class="bp-spec-row" style="margin-top: 8px;">
                <span class="bp-spec-label">Portfolio:</span>
                <span class="bp-spec-value">
                    <a href="https://instagram.com/{{ ltrim($invitation->groom_instagram, '@') }}" target="_blank" rel="noopener noreferrer">
                        @ {{ ltrim($invitation->groom_instagram, '@') }}
                    </a>
                </span>
            </div>
        @endif
    </div>
</div>
