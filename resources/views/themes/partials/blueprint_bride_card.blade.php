<div class="bp-principal-card" data-aos="fade-up" data-aos-delay="100">
    <!-- Corner Crosshairs -->
    <div class="bp-corner-cross bp-corner-tl"></div>
    <div class="bp-corner-cross bp-corner-tr"></div>
    <div class="bp-corner-cross bp-corner-bl"></div>
    <div class="bp-corner-cross bp-corner-br"></div>

    <div class="bp-principal-card-header">
        <span>PRIN-02 // THE BRIDE</span>
        <span class="bp-stamp-cyan-pill">INTERIOR ARCHITECT</span>
    </div>

    <div class="bp-principal-photo-wrap">
        <img src="{{ $bridePhotoUrl }}" alt="{{ $invitation->bride_name }}">
        <div style="font-size: 8px; color: var(--bp-line-cyan); letter-spacing: 1px; text-transform: uppercase; margin-top: 4px; text-align: center;">
            FIG 02.2 PRINCIPAL 02 PROFILE
        </div>
    </div>

    <h3 class="bp-principal-name">{{ $invitation->bride_name }}</h3>
    <div class="bp-principal-role">
        @if($invitation->bride_nickname)
            "{{ $invitation->bride_nickname }}" · 
        @endif
        Perancang Ruang &amp; Estetika
    </div>

    <div class="bp-principal-specs">
        @if($invitation->bride_father_name || $invitation->bride_mother_name)
            <div class="bp-spec-row">
                <span class="bp-spec-label">Ayah:</span>
                <span class="bp-spec-value">{{ $invitation->bride_father_name }}</span>
            </div>
            <div class="bp-spec-row">
                <span class="bp-spec-label">Ibu:</span>
                <span class="bp-spec-value">{{ $invitation->bride_mother_name }}</span>
            </div>
        @elseif($invitation->bride_parents)
            <div class="bp-spec-row">
                <span class="bp-spec-label">Putri Dari:</span>
                <span class="bp-spec-value">{{ $invitation->bride_parents }}</span>
            </div>
        @else
            <div class="bp-spec-row">
                <span class="bp-spec-label">Putri Dari:</span>
                <span class="bp-spec-value">Keluarga Besar Bpk. &amp; Ibu Daniswara</span>
            </div>
        @endif

        @if($invitation->bride_instagram)
            <div class="bp-spec-row" style="margin-top: 8px;">
                <span class="bp-spec-label">Portfolio:</span>
                <span class="bp-spec-value">
                    <a href="https://instagram.com/{{ ltrim($invitation->bride_instagram, '@') }}" target="_blank" rel="noopener noreferrer">
                        @ {{ ltrim($invitation->bride_instagram, '@') }}
                    </a>
                </span>
            </div>
        @endif
    </div>
</div>
