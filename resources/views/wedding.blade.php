{{-- resources/views/wedding.blade.php --}}
<!DOCTYPE html>
<html lang="id" x-data="weddingApp(@js($config ?? []))" :style="{ '--brand': brand }" class="scroll-smooth">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{ ($undangan->nama_panggilan_wanita ?? 'Bride') . ' & ' . ($undangan->nama_panggilan_pria ?? 'Groom') }} — Wedding Invitation</title>
  <meta name="description" content="Undangan pernikahan {{ $undangan->nama_panggilan_wanita }} & {{ $undangan->nama_panggilan_pria }}" />
  <meta property="og:title" content="Undangan: {{ $undangan->nama_panggilan_wanita }} & {{ $undangan->nama_panggilan_pria }}" />
  <meta property="og:description" content="Mohon doa restu & kehadiran Anda." />
  <meta property="og:image" content="{{ $undangan->photo_cover_1 ?? $undangan->photo_cover_2 ?? $undangan->photo_cover_3 }}" />
  <meta property="og:type" content="website" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <style>
    :root { --brand: #1f8a70; }
    .brand-bg { background-color: var(--brand); }
    .brand-text { color: var(--brand); }
    .blur-card { backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); }
  </style>
</head>
<body class="min-h-screen text-slate-800 bg-white" x-init="initSticky()">
  @php
    // ---------- Derive dynamic values from $undangan ----------
    $cover = $undangan->photo_cover_1
      ?? $undangan->photo_cover_2
      ?? $undangan->photo_cover_3
      ?? 'https://images.unsplash.com/photo-1522673607200-164d1b6ce486?q=80&w=1920&auto=format&fit=crop';

    $bridePhoto = $undangan->photo_profile_wanita_1 ?? $undangan->photo_profile_wanita_2 ?? $undangan->photo_profile_wanita_3 ?? 'https://picsum.photos/seed/bride/1200/800';
    $groomPhoto = $undangan->photo_profile_pria_1 ?? $undangan->photo_profile_pria_2 ?? $undangan->photo_profile_pria_3 ?? 'https://picsum.photos/seed/groom/1200/800';

    $igBride = ltrim((string) $undangan->ig_wanita, '@');
    $igGroom = ltrim((string) $undangan->ig_pria, '@');

    $gallery = array_values(array_filter([
      $undangan->photo_berdua_1,
      $undangan->photo_berdua_2,
      $undangan->photo_berdua_3,
      $undangan->photo_gallery_1,
      $undangan->photo_gallery_2,
      $undangan->photo_gallery_3,
      $undangan->photo_gallery_4,
      $undangan->photo_gallery_5,
    ]));

    $parentTextBride = trim(
      'Putri ' . ($undangan->anak_ke_wanita ?: '-') . ' dari Bapak ' . ($undangan->nama_ayah_wanita ?: '-') . ' & Ibu ' . ($undangan->nama_ibu_wanita ?: '-')
    );
    $parentTextGroom = trim(
      'Putra ' . ($undangan->anak_ke_pria ?: '-') . ' dari Bapak ' . ($undangan->nama_ayah_pria ?: '-') . ' & Ibu ' . ($undangan->nama_ibu_pria ?: '-')
    );

    // Event date + time (prefer resepsi_mulai, else pemberkatan_mulai, else 09:00)
    $baseDate = optional($undangan->tanggal_acara);
    $timeStr = $undangan->resepsi_mulai ?: ($undangan->pemberkatan_mulai ?: '09:00');
    $dateISO = $baseDate ? $baseDate->format('Y-m-d') . 'T' . $timeStr . ':00+07:00' : now()->format('c');

    $schedule = [];
    if ($undangan->tanggal_pemberkatan) {
      $schedule[] = [
        'type' => 'Pemberkatan',
        'datetime' => $undangan->tanggal_pemberkatan->format('l, F j, Y') . ' — ' . trim(($undangan->pemberkatan_mulai ?? '') . (isset($undangan->pemberkatan_selesai) ? '–' . $undangan->pemberkatan_selesai : '') . ' WIB'),
        'place' => $undangan->alamat_lokasi_acara,
        'mapUrl' => $undangan->link_google_maps,
      ];
    }
    if ($undangan->tanggal_resepsi) {
      $schedule[] = [
        'type' => 'Resepsi',
        'datetime' => $undangan->tanggal_resepsi->format('l, F j, Y') . ' — ' . trim(($undangan->resepsi_mulai ?? '') . (isset($undangan->resepsi_selesai) ? '–' . $undangan->resepsi_selesai : '') . ' WIB'),
        'place' => $undangan->alamat_lokasi_acara,
        'mapUrl' => $undangan->link_google_maps,
      ];
    }

    $turut = array_values(array_filter([
      $undangan->turut_mengundang_1,
      $undangan->turut_mengundang_2,
    ]));

    $invitee = request('to');

    // Build config for Alpine front-end
    $config = [
      'title' => 'The Wedding Of',
      'heroHeading' => trim(($undangan->nama_panggilan_wanita ?: 'Bride') . ' & ' . ($undangan->nama_panggilan_pria ?: 'Groom')),
      'date' => $dateISO,
      'cover' => $cover,
      'invitee' => $invitee,
      'couple' => [
        'bride' => [
          'name' => $undangan->nama_lengkap_wanita ?: $undangan->nama_panggilan_wanita,
          'parent' => $parentTextBride,
          'instagram' => $igBride,
          'photo' => $bridePhoto,
        ],
        'groom' => [
          'name' => $undangan->nama_lengkap_pria ?: $undangan->nama_panggilan_pria,
          'parent' => $parentTextGroom,
          'instagram' => $igGroom,
          'photo' => $groomPhoto,
        ],
      ],
      'venue' => [
        'name' => 'Lokasi Acara',
        'address' => $undangan->alamat_lokasi_acara,
        'mapUrl' => $undangan->link_google_maps,
      ],
      'schedule' => $schedule,
      'galleryTitle' => 'Precious Moment',
      'gallerySubtitle' => $undangan->quotes ?: 'Creating memories is a priceless gift. Memories last a lifetime.',
      'gallery' => $gallery,
      'live' => [ 'note' => 'Please join the live streaming.', 'url' => '#' ],
      'gift' => [
        'qrisImage' => $undangan->photo_cover_2 ?: null,
        'transfer' => [
          'bank' => 'BANK',
          'name' => trim(($undangan->nama_panggilan_wanita ?: 'Bride') . ' & ' . ($undangan->nama_panggilan_pria ?: 'Groom')),
          'account1' => $undangan->no_rek_amplop_1,
          'account2' => $undangan->no_rek_amplop_2,
        ],
        'note' => $undangan->catatan,
      ],
      'story' => [
        'title' => $undangan->story_judul_1,
        'text'  => $undangan->story_cerita_1,
        'photo' => $undangan->story_photo_1,
      ],
      'alsoInvite' => $turut,
      'bgm' => $undangan->background_musik,
    ];
  @endphp

  {{-- Floating Top Nav --}}
  <div x-data="{open:false, scrolled:false}" @scroll.window="scrolled = window.scrollY > 40" :class="scrolled ? 'opacity-100 translate-y-0' : 'opacity-0 -translate-y-3'" class="fixed top-3 left-1/2 -translate-x-1/2 z-[60] transition-all">
    <nav class="bg-white/90 blur-card rounded-full shadow px-3 py-2 flex items-center gap-2 text-sm">
      <a href="#home" class="px-3 py-1 rounded-full hover:bg-slate-100">Home</a>
      <a href="#couple" class="px-3 py-1 rounded-full hover:bg-slate-100">Couple</a>
      <a href="#story" class="px-3 py-1 rounded-full hover:bg-slate-100">Story</a>
      <a href="#gallery" class="px-3 py-1 rounded-full hover:bg-slate-100">Gallery</a>
      <a href="#date" class="px-3 py-1 rounded-full hover:bg-slate-100">Date</a>
      <a href="#schedule" class="px-3 py-1 rounded-full hover:bg-slate-100">Schedule</a>
      <a href="#rsvp" class="px-3 py-1 rounded-full hover:bg-slate-100">RSVP</a>
      <a href="#gift" class="px-3 py-1 rounded-full hover:bg-slate-100">Gift</a>
    </nav>
  </div>

  @if(request()->boolean('config'))
  <!-- Floating Config Bar (preview helpers) -->
  <div class="fixed z-50 top-4 right-4 bg-white/90 backdrop-blur rounded-full shadow px-4 py-2 flex items-center gap-3">
    <span class="text-xs font-medium">Theme</span>
    <input type="color" x-model="brand" class="h-6 w-6 rounded-full border p-0" aria-label="Pick theme color" />
    <span class="text-xs font-medium ml-2">Overlay</span>
    <input type="range" min="0" max="0.8" step="0.05" x-model.number="overlay" class="w-28" aria-label="Overlay opacity" />
  </div>
  @endif

  <!-- MUSIC CONTROLS -->
  <template x-if="config.bgm">
    <div class="fixed bottom-5 right-5 z-50">
      <audio x-ref="bgm" :src="config.bgm" loop></audio>
      <button @click="toggleMusic()" :class="musicOn ? 'brand-bg text-white' : 'bg-white text-slate-700 border'" class="px-4 py-2 rounded-full shadow border">
        <span x-text="musicOn ? 'Pause Music' : 'Play Music'"></span>
      </button>
    </div>
  </template>

  <!-- HERO -->
  <section id="home" class="relative min-h-screen flex items-center justify-center">
    <img :src="config.cover" alt="Cover" class="absolute inset-0 w-full h-full object-cover" />
    <div class="absolute inset-0" :style="{ backgroundColor: brand, opacity: overlay }"></div>

    <div class="relative z-10 text-center text-white px-6">
      <div class="uppercase tracking-[0.35em] text-xs mb-3 opacity-90" x-text="config.title"></div>
      <h1 class="text-4xl md:text-6xl font-light mb-6" x-text="config.heroHeading"></h1>
      <template x-if="config.invitee">
        <div class="inline-block px-4 py-2 rounded-full bg-white/20 blur-card border border-white/30 mb-4">Kepada Yth: <span class="font-semibold" x-text="config.invitee"></span></div>
      </template>
      <div class="flex flex-col items-center gap-3">
        <div class="grid grid-cols-3 gap-2">
          <template x-for="part in dateParts(config.date)" :key="part">
            <div class="w-16 h-16 rounded-2xl bg-white/80 backdrop-blur border border-white/60 flex items-center justify-center text-2xl font-semibold" x-text="part"></div>
          </template>
        </div>
        <div class="text-sm opacity-90" x-text="dateLabel(config.date)"></div>
      </div>
      <div class="mt-8 flex items-center justify-center gap-3">
        <a href="#couple" @click.prevent="openInvite()" class="px-6 py-3 rounded-full bg-white text-slate-900 font-medium shadow hover:opacity-95">Buka Undangan</a>
        <button @click="downloadICS()" class="px-5 py-3 rounded-full border border-white/70 bg-white/10 hover:bg-white/20">Add to Calendar</button>
      </div>
      <div class="mt-6 text-sm opacity-90" x-show="countdown.ready">
        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15">Mulai dalam: <span x-text="countdown.text"></span></span>
      </div>
    </div>
  </section>

  <!-- COUPLE -->
  <section id="couple" class="py-20 px-6 max-w-6xl mx-auto">
    <div class="grid md:grid-cols-2 gap-10 items-center">
      <template x-for="person in [config.couple.bride, config.couple.groom]" :key="person.name">
        <div class="grid grid-rows-[auto_auto] gap-4">
          <div class="relative rounded-3xl overflow-hidden shadow-lg">
            <img :src="person.photo" :alt="person.name" class="w-full h-80 object-cover" />
            <template x-if="person.instagram">
              <a :href="'https://instagram.com/' + person.instagram" target="_blank" class="absolute top-4 right-4 inline-flex items-center gap-2 bg-white/90 backdrop-blur px-3 py-1.5 rounded-full text-sm">
                <span>@</span><span x-text="person.instagram"></span>
              </a>
            </template>
          </div>
          <div class="px-1">
            <h3 class="text-2xl font-semibold" x-text="person.name"></h3>
            <p class="mt-1 opacity-80 text-sm" x-text="person.parent"></p>
          </div>
        </div>
      </template>
    </div>
  </section>

  <!-- QUOTE -->
  <section class="py-8 px-6 max-w-3xl mx-auto" x-show="config.gallerySubtitle">
    <blockquote class="text-center text-lg md:text-xl italic text-slate-700">“<span x-text="config.gallerySubtitle"></span>”</blockquote>
  </section>

  <!-- STORY -->
  <section id="story" class="py-12 px-6 max-w-5xl mx-auto" x-show="config.story && (config.story.title || config.story.text || config.story.photo)">
    <div class="grid md:grid-cols-2 gap-6 items-center">
      <template x-if="config.story.photo">
        <img :src="config.story.photo" alt="Our Story" class="w-full h-72 object-cover rounded-3xl" />
      </template>
      <div>
        <h2 class="text-3xl font-semibold" x-text="config.story.title || 'Our Story'"></h2>
        <p class="mt-3 leading-relaxed opacity-80" x-text="config.story.text"></p>
      </div>
    </div>
  </section>

  <!-- GALLERY -->
  <section id="gallery" class="py-16 px-6 max-w-6xl mx-auto" x-show="config.gallery.length">
    <div class="text-center mb-8">
      <h2 class="text-3xl font-semibold" x-text="config.galleryTitle"></h2>
      <p class="opacity-70 mt-2 text-sm" x-text="config.gallerySubtitle"></p>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-4">
      <template x-for="(src, i) in config.gallery" :key="i">
        <img :src="src" :alt="'Gallery ' + (i+1)" class="w-full h-40 md:h-56 object-cover rounded-2xl" />
      </template>
    </div>
  </section>

  <!-- SAVE THE DATE / VENUE -->
  <section id="date" class="py-20 px-6 max-w-5xl mx-auto text-center">
    <div class="inline-flex items-center gap-3 px-4 py-2 rounded-full brand-bg text-white">Save the Date</div>
    <div class="mt-6">
      <div class="flex flex-col items-center gap-3">
        <div class="grid grid-cols-3 gap-2">
          <template x-for="part in dateParts(config.date)" :key="part">
            <div class="w-16 h-16 rounded-2xl bg-white border border-slate-200 flex items-center justify-center text-2xl font-semibold" x-text="part"></div>
          </template>
        </div>
        <div class="text-sm opacity-80" x-text="dateLabel(config.date)"></div>
      </div>
    </div>
    <div class="mt-6 max-w-2xl mx-auto opacity-80">
      <p class="font-medium">Lokasi Acara</p>
      <p x-text="config.venue.address"></p>
    </div>
    <div class="mt-6" x-show="config.venue.mapUrl">
      <a :href="config.venue.mapUrl" target="_blank" class="inline-flex items-center gap-2 px-5 py-2 rounded-full border border-slate-300 hover:bg-slate-50">Open in Maps</a>
    </div>
  </section>

  <!-- SCHEDULE -->
  <section id="schedule" class="py-16 px-6 max-w-5xl mx-auto" x-show="config.schedule.length">
    <div class="grid md:grid-cols-2 gap-6">
      <template x-for="(s, i) in config.schedule" :key="i">
        <div class="p-6 rounded-3xl border bg-white shadow-sm">
          <h3 class="text-xl font-semibold" x-text="s.type"></h3>
          <p class="mt-2 opacity-80" x-text="s.datetime"></p>
          <p class="opacity-80" x-text="s.place"></p>
          <template x-if="s.mapUrl">
            <a :href="s.mapUrl" target="_blank" class="mt-4 inline-flex items-center gap-2 px-4 py-2 rounded-full brand-bg text-white">View Map</a>
          </template>
        </div>
      </template>
    </div>
  </section>

  <!-- RSVP + Live + Gift -->
  <section class="py-16 px-6 max-w-5xl mx-auto" id="rsvp">
    <div class="grid md:grid-cols-2 gap-8">
      <!-- RSVP (local-only demo) -->
      <div class="p-6 rounded-3xl border bg-white shadow-sm" x-data>
        <h3 class="text-2xl font-semibold">Reservation (RSVP)</h3>
        <p class="mt-1 text-sm opacity-70">
          <span x-text="attending"></span>
          <span x-text="attending === 1 ? ' guest will join — send your response too.' : ' guests will join — send your response too.'"></span>
        </p>
        <form class="mt-4 grid gap-3" @submit.prevent="submitRSVP($event)">
          <input name="name" required placeholder="Your name" class="w-full px-4 py-2 rounded-xl border" />
          <select name="status" class="w-full px-4 py-2 rounded-xl border">
            <option value="yes">Will attend</option>
            <option value="no">Cannot attend</option>
          </select>
          <input type="number" name="guests" min="1" placeholder="Number of guests" class="w-full px-4 py-2 rounded-xl border" />
          <textarea name="note" placeholder="Notes (optional)" class="w-full px-4 py-2 rounded-xl border"></textarea>
          <button type="submit" class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl brand-bg text-white">Send RSVP</button>
        </form>
        <template x-if="rsvps.length">
          <div class="mt-6">
            <div class="text-sm font-medium mb-2">Recent responses</div>
            <ul class="space-y-2 max-h-40 overflow-auto pr-2">
              <template x-for="(r, idx) in rsvps" :key="idx">
                <li class="text-sm opacity-80">
                  <span class="font-medium" x-text="r.name"></span>
                  — <span x-text="r.status"></span>
                  <template x-if="r.guests"><span x-text="' (+' + r.guests + ')' "></span></template>
                  <template x-if="r.note"><span x-text="' · ' + r.note"></span></template>
                </li>
              </template>
            </ul>
          </div>
        </template>
      </div>

      <!-- Right column: Live + Gift -->
      <div class="grid gap-8">
        <!-- Live -->
        <div class="p-6 rounded-3xl border bg-white shadow-sm" x-show="config.live && (config.live.note || config.live.url)">
          <h3 class="text-2xl font-semibold">Live Streaming</h3>
          <p class="mt-1 opacity-80" x-text="config.live.note"></p>
          <template x-if="config.live.url">
            <a :href="config.live.url" target="_blank" class="mt-4 inline-flex items-center gap-2 px-4 py-2 rounded-full bg-black text-white">Go to Streaming</a>
          </template>
        </div>
        <!-- Gift -->
        <div id="gift" class="p-6 rounded-3xl border bg-white shadow-sm">
          <h3 class="text-2xl font-semibold">Wedding Gift</h3>
          <div class="mt-3 grid grid-cols-3 gap-3 items-start">
            <template x-if="config.gift.qrisImage">
              <img :src="config.gift.qrisImage" alt="QRIS" class="col-span-1 rounded-xl object-cover h-32 w-full" />
            </template>
            <div class="col-span-2 text-sm space-y-2">
              <div class="font-medium">QRIS / Transfer</div>
              <template x-if="config.gift.transfer.account1">
                <div class="flex items-center gap-2">
                  <div><span x-text="config.gift.transfer.bank"></span> — <span x-text="config.gift.transfer.name"></span></div>
                  <button @click="copy(config.gift.transfer.account1)" class="text-xs px-2 py-1 rounded border">Copy</button>
                </div>
              </template>
              <template x-if="config.gift.transfer.account2">
                <div class="flex items-center gap-2">
                  <div><span x-text="config.gift.transfer.bank"></span> — <span x-text="config.gift.transfer.name"></span></div>
                  <button @click="copy(config.gift.transfer.account2)" class="text-xs px-2 py-1 rounded border">Copy</button>
                </div>
              </template>
              <div class="select-all font-mono text-lg" x-text="config.gift.transfer.account1 || config.gift.transfer.account2"></div>
              <p class="mt-3 opacity-70" x-text="config.gift.note"></p>
              <div class="flex gap-2 pt-2">
                <button @click="shareWA()" class="px-3 py-2 rounded border">Share via WhatsApp</button>
                <button @click="copy(window.location.href)" class="px-3 py-2 rounded border">Copy Link</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ALSO INVITE -->
  <section class="py-10 px-6 max-w-3xl mx-auto" x-show="config.alsoInvite && config.alsoInvite.length">
    <h3 class="text-xl font-semibold mb-2">Turut Mengundang</h3>
    <ul class="list-disc list-inside space-y-1">
      <template x-for="(t, i) in config.alsoInvite" :key="i">
        <li x-text="t"></li>
      </template>
    </ul>
  </section>

  <!-- WISHES / GUESTBOOK -->
  <section class="py-16 px-6 max-w-5xl mx-auto">
    <h3 class="text-2xl font-semibold">Wishes</h3>
    <form class="mt-4 grid md:grid-cols-3 gap-3" @submit.prevent="submitWish($event)">
      <input name="name" placeholder="Your name" class="px-4 py-2 rounded-xl border" />
      <input name="location" placeholder="Your location" class="px-4 py-2 rounded-xl border" />
      <input name="text" required placeholder="Your wish" class="px-4 py-2 rounded-xl border md:col-span-1 col-span-3" />
      <button type="submit" class="md:col-start-3 px-4 py-2 rounded-xl brand-bg text-white">Send Wish</button>
    </form>
    <ul class="mt-6 space-y-4">
      <template x-for="(w, i) in wishes" :key="i">
        <li class="p-4 rounded-2xl border bg-white/70">
          <div class="font-medium" x-text="'“' + w.text + '”'"></div>
          <div class="text-sm opacity-70"><span x-text="w.name || 'Anon'"></span><span x-text="w.location ? ' · ' + w.location : ''"></span></div>
        </li>
      </template>
    </ul>
  </section>

  <!-- FOOTER -->
  <footer class="py-16 px-6 text-center bg-gradient-to-b from-white to-slate-50">
    <div class="text-sm max-w-xl mx-auto opacity-80">
      Merupakan kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i
      berkenan hadir untuk memberikan doa restu.
    </div>
    <div class="mt-6 text-xs opacity-60">© <span x-text="new Date().getFullYear()"></span> <span x-text="(config.couple.bride.name?.split(' ')[0] || 'Bride') + ' & ' + (config.couple.groom.name?.split(' ')[0] || 'Groom')"></span></div>
  </footer>

  <!-- Alpine App using dynamic $config -->
  <script>
    function weddingApp(initial = {}) {
      const storage = {
        get(key, fallback) { try { return JSON.parse(localStorage.getItem(key)) ?? fallback; } catch { return fallback; } },
        set(key, val) { try { localStorage.setItem(key, JSON.stringify(val)); } catch {} }
      };

      return {
        brand: storage.get('brand', '#1f8a70'),
        overlay: storage.get('overlay', 0.35),
        attending: storage.get('attending', 0),
        rsvps: storage.get('rsvps', []),
        wishes: storage.get('wishes', []),
        musicOn: false,
        countdown: {ready:false, text:''},
        config: Object.assign({
          title: 'The Wedding Of',
          heroHeading: 'Our Wedding',
          date: new Date().toISOString(),
          cover: '',
          invitee: '',
          couple: { bride: { name: '', parent: '', instagram: '', photo: '' }, groom: { name: '', parent: '', instagram: '', photo: '' } },
          venue: { name: '', address: '', mapUrl: '' },
          schedule: [],
          galleryTitle: 'Precious Moment',
          gallerySubtitle: '',
          gallery: [],
          live: { note: '', url: '' },
          gift: { qrisImage: '', transfer: { bank: '', name: '', account1: '', account2: '' }, note: '' },
          story: { title: '', text: '', photo: '' },
          alsoInvite: [],
          bgm: ''
        }, initial),

        init() {
          this.$watch('brand', (v) => storage.set('brand', v));
          this.$watch('overlay', (v) => storage.set('overlay', v));
          this.initCountdown();
        },

        initSticky(){},

        // Countdown every second
        initCountdown() {
          const target = new Date(this.config.date).getTime();
          const tick = () => {
            const now = Date.now();
            let diff = Math.max(0, target - now);
            const d = Math.floor(diff / (1000*60*60*24)); diff -= d*86400000;
            const h = Math.floor(diff / (1000*60*60)); diff -= h*3600000;
            const m = Math.floor(diff / (1000*60)); diff -= m*60000;
            const s = Math.floor(diff / 1000);
            this.countdown.text = `${d} hari ${h} jam ${m} mnt ${s} dtk`;
            this.countdown.ready = true;
          };
          tick();
          setInterval(tick, 1000);
        },

        toggleMusic() {
          const a = this.$refs.bgm;
          if (!a) return;
          if (this.musicOn) { a.pause(); this.musicOn = false; }
          else {
            a.play().then(() => { this.musicOn = true; }).catch(() => { /* autoplay blocked */ });
          }
        },

        openInvite(){
          const a = this.$refs.bgm; if(a && !this.musicOn){ this.toggleMusic(); }
          document.querySelector('#couple')?.scrollIntoView({behavior:'smooth'});
        },

        submitRSVP(e) {
          const f = new FormData(e.target);
          const name = f.get('name');
          const status = f.get('status');
          const guests = Number(f.get('guests') || 1);
          const note = f.get('note');
          const entry = { name, status, guests, note, ts: Date.now() };
          this.rsvps = [entry, ...this.rsvps];
          if (status === 'yes') this.attending = this.attending + guests;
          storage.set('rsvps', this.rsvps);
          storage.set('attending', this.attending);
          e.target.reset();
        },
        submitWish(e) {
          const f = new FormData(e.target);
          const name = f.get('name');
          const location = f.get('location');
          const text = f.get('text');
          if (!text) return;
          this.wishes = [{ name, location, text }, ...this.wishes];
          storage.set('wishes', this.wishes);
          e.target.reset();
        },

        copy(text){
          if(!text) return;
          navigator.clipboard?.writeText(text);
        },
        shareWA(){
          const url = encodeURIComponent(window.location.href);
          const text = encodeURIComponent(`Undangan pernikahan ${this.config.couple.bride.name} & ${this.config.couple.groom.name}. ${url}`);
          window.open(`https://wa.me/?text=${text}`, '_blank');
        },
        downloadICS(){
          const start = new Date(this.config.date);
          const end = new Date(start.getTime()+2*60*60*1000);
          const dt = (d) => d.toISOString().replace(/[-:]/g,'').split('.')[0] + 'Z';
          const ics = [
            'BEGIN:VCALENDAR','VERSION:2.0','PRODID:-//Wedding//Invite//EN','BEGIN:VEVENT',
            `UID:${crypto.randomUUID?.() || Math.random()}`,
            `DTSTAMP:${dt(new Date())}`,
            `DTSTART:${dt(start)}`,
            `DTEND:${dt(end)}`,
            `SUMMARY:Wedding ${this.config.couple.bride.name} & ${this.config.couple.groom.name}`,
            `DESCRIPTION:Mohon doa restu & kehadiran Anda`,
            `LOCATION:${this.config.venue.address || ''}`,
            'END:VEVENT','END:VCALENDAR'
          ].join('
');
          const blob = new Blob([ics], {type:'text/calendar'});
          const link = document.createElement('a');
          link.href = URL.createObjectURL(blob);
          link.download = `wedding-${Date.now()}.ics`;
          link.click();
          URL.revokeObjectURL(link.href);
        }
      }
    }
  </script>
</body>
</html>
