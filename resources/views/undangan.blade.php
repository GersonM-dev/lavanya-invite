{{-- resources/views/wedding.blade.php --}}
<!DOCTYPE html>
<html lang="en" x-data="weddingApp(@js($undangan))" :style="{ '--brand': brand }" class="scroll-smooth"
  xmlns:x-bind="http://www.w3.org/1999/xhtml">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Wedding Invitation</title>
  {{-- Tailwind CSS (CDN for demo). In production, use your compiled app.css via Vite. --}}
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css" />
  {{-- Alpine.js --}}
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <style>
    :root {
      --brand: #1f8a70;
    }

    .brand-bg {
      background-color: var(--brand);
    }

    .brand-text {
      color: var(--brand);
    }

    .brand-border {
      border-color: var(--brand);
    }
  </style>
</head>

<body class="min-h-screen text-slate-800 bg-white">
  <!-- Floating Config Bar (demo helpers) -->
  <!-- <div class="fixed z-50 top-4 left-1/2 -translate-x-1/2 bg-white/90 backdrop-blur rounded-full shadow px-4 py-2 flex items-center gap-3">
    <span class="text-xs font-medium">Theme</span>
    <input type="color" x-model="brand" class="h-6 w-6 rounded-full border p-0" aria-label="Pick theme color" />
    <span class="text-xs font-medium ml-2">Overlay</span>
    <input type="range" min="0" max="0.8" step="0.05" x-model.number="overlay" class="w-28" aria-label="Overlay opacity" />
  </div> -->

  <!-- HERO -->
  <section class="relative min-h-screen flex items-center justify-center">
    <img :src="config.cover" alt="Cover" class="absolute inset-0 w-full h-full object-cover" />
    <div class="absolute inset-0" :style="{ backgroundColor: brand, opacity: overlay }"></div>

    <div class="relative z-10 text-center text-white px-6" data-aos="fade-up" data-aos-duration="800">
      <div class="uppercase tracking-[0.35em] text-xs mb-3 opacity-90" x-text="config.title"></div>
      <h1 class="text-4xl md:text-6xl font-light mb-6" x-text="config.heroHeading"></h1>
      <div class="flex flex-col items-center gap-3">
        <!-- Date blocks -->
        <div class="grid grid-cols-3 gap-2">
          <template x-for="part in dateParts(config.date)" :key="part">
            <div
              class="w-16 h-16 rounded-2xl bg-white/40 backdrop-blur border border-white/60 flex items-center justify-center text-2xl font-semibold"
              x-text="part"></div>
          </template>
        </div>
        <div class="text-sm opacity-80" x-text="dateLabel(config.date)"></div>
      </div>
      <a href="#couple"
        class="inline-block mt-8 px-6 py-3 rounded-full bg-white text-slate-900 font-medium shadow hover:opacity-95">Open
        Invitation</a>
    </div>
  </section>

  <!-- COUPLE -->
  <section id="couple" class="py-20 px-6 max-w-6xl mx-auto">
    <div class="grid md:grid-cols-2 gap-10 items-center">
      <template x-for="person in [config.couple.bride, config.couple.groom]" :key="person.name">
        <div class="grid grid-rows-[auto_auto] gap-4" data-aos="fade-up" :data-aos-delay="i * 100">
          <div class="relative rounded-3xl overflow-hidden shadow-lg">
            <img :src="person.photo" :alt="person.name" class="w-full h-80 object-cover" />
            <a :href="'https://instagram.com/' + person.instagram" target="_blank"
              class="absolute top-4 right-4 inline-flex items-center gap-2 bg-white/90 backdrop-blur px-3 py-1.5 rounded-full text-sm">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-4 h-4" fill="currentColor">
                <path
                  d="M7 2C4.2 2 2 4.2 2 7v10c0 2.8 2.2 5 5 5h10c2.8 0 5-2.2 5-5V7c0-2.8-2.2-5-5-5H7zm0 2h10c1.7 0 3 1.3 3 3v10c0 1.7-1.3 3-3 3H7c-1.7 0-3-1.3-3-3V7c0-1.7 1.3-3 3-3zm5 2.8a5.2 5.2 0 100 10.4 5.2 5.2 0 000-10.4zm0 2a3.2 3.2 0 110 6.4 3.2 3.2 0 010-6.4zM18.5 6A1.5 1.5 0 1018.5 9 1.5 1.5 0 0018.5 6z" />
              </svg>
              <span x-text="'@' + person.instagram"></span>
            </a>
          </div>
          <div class="px-1">
            <h3 class="text-2xl font-semibold" x-text="person.name"></h3>
            <p class="mt-1 opacity-80 text-sm" x-text="person.parent"></p>
            <p class="opacity-70 text-sm" x-text="person.location"></p>
          </div>
        </div>
      </template>
    </div>
  </section>

  <!-- GALLERY -->
  <section class="py-16 px-6 max-w-6xl mx-auto" data-aos="fade-up">
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
  <section class="py-20 px-6 max-w-5xl mx-auto text-center">
    <div class="inline-flex items-center gap-3 px-4 py-2 rounded-full brand-bg text-white">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-4 h-4 fill-current">
        <path
          d="M7 2a1 1 0 011 1v1h8V3a1 1 0 112 0v1h1a2 2 0 012 2v12a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2h1V3a1 1 0 112 0v1zm13 7H4v9a1 1 0 001 1h14a1 1 0 001-1V9zM5 7h14V6H5v1z" />
      </svg>
      <span>Save the Date</span>
    </div>
    <div class="mt-6">
      <div class="flex flex-col items-center gap-3">
        <div class="grid grid-cols-3 gap-2">
          <template x-for="part in dateParts(config.date)" :key="part">
            <div
              class="w-16 h-16 rounded-2xl bg-white border border-slate-200 flex items-center justify-center text-2xl font-semibold"
              x-text="part"></div>
          </template>
        </div>
        <div class="text-sm opacity-80" x-text="dateLabel(config.date)"></div>
      </div>
    </div>
    <div class="mt-6 max-w-2xl mx-auto opacity-80">
      <p class="font-medium" x-text="config.venue.name"></p>
      <p x-text="config.venue.address"></p>
    </div>
    <div class="mt-6">
      <a :href="config.venue.mapUrl" target="_blank"
        class="inline-flex items-center gap-2 px-5 py-2 rounded-full border border-slate-300 hover:bg-slate-50">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-4 h-4 fill-current">
          <path d="M12 2a7 7 0 017 7c0 5.25-7 13-7 13S5 14.25 5 9a7 7 0 017-7zm0 4a3 3 0 100 6 3 3 0 000-6z" />
        </svg>
        <span>Open in Maps</span>
      </a>
    </div>
  </section>

  <!-- SCHEDULE -->
  <section class="py-16 px-6 max-w-5xl mx-auto">
    <div class="grid md:grid-cols-2 gap-6">
      <template x-for="(s, i) in config.schedule" :key="i">
        <div class="p-6 rounded-3xl border bg-white shadow-sm" data-aos="fade-up" :data-aos-delay="i * 100">
          <h3 class="text-xl font-semibold" x-text="s.type"></h3>
          <p class="mt-2 opacity-80" x-text="s.datetime"></p>
          <p class="opacity-80" x-text="s.place"></p>
          <a :href="s.mapUrl" target="_blank"
            class="mt-4 inline-flex items-center gap-2 px-4 py-2 rounded-full brand-bg text-white">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-4 h-4 fill-current">
              <path d="M12 2a7 7 0 017 7c0 5.25-7 13-7 13S5 14.25 5 9a7 7 0 017-7zm0 4a3 3 0 100 6 3 3 0 000-6z" />
            </svg>
            <span>View Map</span>
          </a>
        </div>
      </template>
    </div>
  </section>

  <!-- RSVP + Live + Gift -->
  <section class="py-16 px-6 max-w-5xl mx-auto" id="rsvp">
    <div class="grid md:grid-cols-2 gap-8">
      <!-- RSVP -->
      <div class="p-6 rounded-3xl border bg-white shadow-sm" x-data data-aos="fade-up">
        <h3 class="text-2xl font-semibold">Reservation (RSVP)</h3>
        <p class="mt-1 text-sm opacity-70">
          <span x-text="attending"></span>
          <span
            x-text="attending === 1 ? ' guest will join — send your response too.' : ' guests will join — send your response too.'"></span>
        </p>
        <form class="mt-4 grid gap-3" @submit.prevent="submitRSVP($event)">
          <input name="name" required placeholder="Your name" class="w-full px-4 py-2 rounded-xl border" />
          <select name="status" class="w-full px-4 py-2 rounded-xl border">
            <option value="yes">Will attend</option>
            <option value="no">Cannot attend</option>
          </select>
          <input type="number" name="guests" min="1" placeholder="Number of guests"
            class="w-full px-4 py-2 rounded-xl border" />
          <textarea name="note" placeholder="Notes (optional)" class="w-full px-4 py-2 rounded-xl border"></textarea>
          <button type="submit"
            class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl brand-bg text-white">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-4 h-4 fill-current">
              <path d="M21 3L8 16l-4 5 5-4L21 3zM17 3h4v4L17 3z" />
            </svg>
            <span>Send RSVP</span>
          </button>
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
        <div class="p-6 rounded-3xl border bg-white shadow-sm" data-aos="fade-up">
          <h3 class="text-2xl font-semibold">Live Streaming</h3>
          <p class="mt-1 opacity-80" x-text="config.live.note"></p>
          <a :href="config.live.url" target="_blank"
            class="mt-4 inline-flex items-center gap-2 px-4 py-2 rounded-full bg-black text-white">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-4 h-4 fill-current">
              <path d="M8 5v14l11-7-11-7z" />
            </svg>
            <span>Go to Streaming</span>
          </a>
        </div>
        <!-- Gift -->
        <div class="p-6 rounded-3xl border bg-white shadow-sm">
          <h3 class="text-2xl font-semibold">Wedding Gift</h3>
          <div class="mt-3 grid grid-cols-3 gap-3 items-start">
            <img :src="config.gift.qrisImage" alt="QRIS" class="col-span-1 rounded-xl object-cover h-32 w-full" />
            <div class="col-span-2 text-sm">
              <div class="font-medium flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-4 h-4 fill-current">
                  <path
                    d="M20 7h-3.2A2.8 2.8 0 0012 5.2 2.8 2.8 0 007.2 7H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2zm-8-1.6c.88 0 1.6.72 1.6 1.6H10.4c0-.88.72-1.6 1.6-1.6zM20 11H4v8h16v-8z" />
                </svg>
                <span>QRIS / Transfer</span>
              </div>
              <div class="mt-2 opacity-80">
                <div><span x-text="config.gift.transfer.bank"></span> — <span x-text="config.gift.transfer.name"></span>
                </div>
                <div class="select-all font-mono text-lg" x-text="config.gift.transfer.account"></div>
              </div>
              <p class="mt-3 opacity-70" x-text="config.gift.note"></p>
            </div>
          </div>
          <a href="#gift"
            class="mt-4 inline-flex items-center gap-2 px-4 py-2 rounded-full border border-slate-300 hover:bg-slate-50">Make
            a Gift</a>
        </div>
      </div>
    </div>
  </section>

  <!-- WISHES / GUESTBOOK -->
  <section class="py-16 px-6 max-w-5xl mx-auto" data-aos="fade-up">
    <h3 class="text-2xl font-semibold">Wishes</h3>
    <form class="mt-4 grid md:grid-cols-3 gap-3" @submit.prevent="submitWish($event)">
      <input name="name" placeholder="Your name" class="px-4 py-2 rounded-xl border" />
      <input name="location" placeholder="Your location" class="px-4 py-2 rounded-xl border" />
      <input name="text" required placeholder="Your wish"
        class="px-4 py-2 rounded-xl border md:col-span-1 col-span-3" />
      <button type="submit" class="md:col-start-3 px-4 py-2 rounded-xl brand-bg text-white">Send Wish</button>
    </form>
    <ul class="mt-6 space-y-4">
      <template x-for="(w, i) in wishes" :key="i">
        <li class="p-4 rounded-2xl border bg-white/70">
          <div class="font-medium" x-text="'“' + w.text + '”'"></div>
          <div class="text-sm opacity-70"><span x-text="w.name || 'Anon'"></span><span
              x-text="w.location ? ' · ' + w.location : ''"></span></div>
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
    <div class="mt-6 text-xs opacity-60">© <span x-text="new Date().getFullYear()"></span> <span
        x-text="config.couple.bride.name.split(' ')[0] + ' & ' + config.couple.groom.name.split(' ')[0]"></span></div>
  </footer>

  <!-- Alpine App -->
  <script>
    function weddingApp(modelData) {
      const storage = {
        get(key, fallback) { try { return JSON.parse(localStorage.getItem(key)) ?? fallback; } catch { return fallback; } },
        set(key, val) { try { localStorage.setItem(key, JSON.stringify(val)); } catch { } }
      };

      function abs(u) {
        if (!u) return '';
        if (/^https?:\/\//i.test(u)) return u;

        // Remove any leading slashes and "undangan/" prefix
        const cleaned = String(u)
          .replace(/^\/?undangan\//i, '') // strip "undangan/"
          .replace(/^\/+/, '');           // strip extra leading slashes

        // Return with /storage/ prefix
        return `${window.location.origin}/storage/${cleaned}`;
      };

      function ig(handle) {
        return (handle || '').toString().replace(/^@/, '');
      }

      return {
        // THEME CONTROLS
        brand: storage.get('brand', '#1f8a70'),
        overlay: storage.get('overlay', 0.35),

        // COUNTERS & LISTS
        attending: storage.get('attending', 0),
        rsvps: storage.get('rsvps', []),
        wishes: storage.get('wishes', []),

        // CONFIG DATA
        config: {
          title: 'The Wedding Of',
          heroHeading: modelData.quotes ?? '',
          date: modelData.tanggal_acara,
          cover: abs(modelData.photo_cover_1),
          couple: {
            bride: {
              name: modelData.nama_lengkap_wanita,
              parent: `Putri ${modelData.anak_ke_wanita} dari ${modelData.nama_ayah_wanita} & ${modelData.nama_ibu_wanita}`,
              instagram: ig(modelData.ig_wanita),
              photo: abs(modelData.photo_profile_wanita_1),
            },
            groom: {
              name: modelData.nama_lengkap_pria,
              parent: `Putra ${modelData.anak_ke_pria} dari ${modelData.nama_ayah_pria} & ${modelData.nama_ibu_pria}`,
              instagram: ig(modelData.ig_pria),
              photo: abs(modelData.photo_profile_pria_1),
            },
          },
          venue: {
            name: modelData.alamat_lokasi_acara,
            address: modelData.alamat_lokasi_acara,
            mapUrl: modelData.link_google_maps || '#',
          },
          schedule: [
            {
              type: 'Pemberkatan',
              datetime: `${modelData.tanggal_pemberkatan} — ${modelData.pemberkatan_mulai} s/d ${modelData.pemberkatan_selesai}`,
              place: modelData.alamat_lokasi_acara,
              mapUrl: modelData.link_google_maps || '#',
            },
            {
              type: 'Resepsi',
              datetime: `${modelData.tanggal_resepsi} — ${modelData.resepsi_mulai} s/d ${modelData.resepsi_selesai}`,
              place: modelData.alamat_lokasi_acara,
              mapUrl: modelData.link_google_maps || '#',
            },
          ],
          gallery: [
            abs(modelData.photo_gallery_1),
            abs(modelData.photo_gallery_2),
            abs(modelData.photo_gallery_3),
            abs(modelData.photo_gallery_4),
            abs(modelData.photo_gallery_5),
          ].filter(Boolean),
          live: {
            note: modelData.live_note ?? 'Please join the live streaming.',
            url: modelData.live_url ?? 'https://instagram.com/',
          },
          gift: {
            qrisImage: abs(modelData.qrisImage) || abs(modelData.photo_cover_2),
            transfer: {
              bank: 'BCA',
              name: `${modelData.nama_lengkap_wanita} & ${modelData.nama_lengkap_pria}`,
              account: modelData.no_rek_amplop_1 || '-',
            },
            note: modelData.catatan ?? '',
          },
        }, // ← ← ← THIS COMMA FIXES THE PARSE ERROR

        // Helpers
        dateParts(iso) {
          const d = new Date(iso);
          const dd = String(d.getDate()).padStart(2, '0');
          const mm = String(d.getMonth() + 1).padStart(2, '0');
          const yy = String(d.getFullYear()).slice(-2);
          return [dd, mm, yy];
        },
        dateLabel(iso) {
          const d = new Date(iso);
          return d.toLocaleString('en-US', { month: 'long', year: 'numeric' });
        },

        // Actions
        submitRSVP(e) {
          const f = new FormData(e.target);
          const entry = {
            name: f.get('name'),
            status: f.get('status'),
            guests: Number(f.get('guests') || 1),
            note: f.get('note'),
            ts: Date.now(),
          };
          this.rsvps = [entry, ...this.rsvps];
          if (entry.status === 'yes') this.attending = this.attending + entry.guests;
          storage.set('rsvps', this.rsvps);
          storage.set('attending', this.attending);
          e.target.reset();
          this.$nextTick(() => AOS.refresh());
        },
        submitWish(e) {
          const f = new FormData(e.target);
          const text = f.get('text');
          if (!text) return;
          this.wishes = [{ name: f.get('name'), location: f.get('location'), text }, ...this.wishes];
          storage.set('wishes', this.wishes);
          e.target.reset();
          this.$nextTick(() => AOS.refresh());
        },

        init() {
          this.$watch('brand', (v) => storage.set('brand', v));
          this.$watch('overlay', (v) => storage.set('overlay', v));
        }
      };
    }
  </script>

  <!-- Before </body>: after your <script> that defines weddingApp -->
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script>
    document.addEventListener('alpine:init', () => {
      // Initialize once Alpine is ready
      AOS.init({
        once: true,
        duration: 700,
        easing: 'ease-out-cubic',
        offset: 80
      });
    });
  </script>


</body>

</html>