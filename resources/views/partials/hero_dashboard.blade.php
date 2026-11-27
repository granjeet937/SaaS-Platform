@push('styles')
<style>
/* ===== LMSP HERO SCENE (16:9 Compact & Scoped) ===== */
.lmsp-hero-scene {
  --ink: #0b1f3f;
  --mut: #64748b;
  --line: #e6eefa;
  position: relative;
  box-sizing: border-box;
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 14px;
  padding: 10px 6px;
  perspective: 1400px;
  color: var(--ink);
}
.lmsp-hero-scene * { box-sizing: border-box; }
.lmsp-hero-scene .lmsp-fx { position: absolute; inset: 0; pointer-events: none; overflow: hidden; }
.lmsp-hero-scene .lmsp-fx span {
  position: absolute; bottom: -10px; border-radius: 50%;
  background: rgba(125, 211, 252, .55); box-shadow: 0 0 10px #38bdf8;
  animation: lmsp-rise linear infinite;
}
@keyframes lmsp-rise {
  from { transform: translateY(0); opacity: 0; }
  15% { opacity: 1; }
  to { transform: translateY(-50vh); opacity: 0; }
}

/* Compact 16:9 Stage (max-width: 540px — adjust 480px-580px if needed) */
.lmsp-hero-scene .lmsp-stage {
  position: relative;
  width: min(540px, 100%);
  aspect-ratio: 16 / 9;
  transform-style: preserve-3d;
  will-change: transform;
}
.lmsp-hero-scene .lmsp-fit { position: absolute; left: 0; top: 0; transform-origin: 0 0; }
.lmsp-hero-scene .lmsp-window {
  display: flex; width: 100%; height: 100%; border-radius: 24px; overflow: hidden;
  background: rgba(255, 255, 255, .96);
  box-shadow: 0 32px 70px -18px rgba(0, 0, 0, .55), 0 0 0 1px rgba(255, 255, 255, .6) inset;
  font-size: 15px;
  text-align: left;
}

/* Sidebar */
.lmsp-hero-scene .lmsp-side { width: 220px; flex: none; background: #07162e; padding: 26px 16px; color: #9fb3d1; }
.lmsp-hero-scene .lmsp-logo { display: flex; align-items: center; gap: 11px; color: #fff; font-weight: 800; letter-spacing: 1.6px; font-size: 21px; margin: 0 8px 32px; }
.lmsp-hero-scene .lmsp-logo b { width: 38px; height: 38px; flex: none; border-radius: 11px; display: grid; place-items: center; background: linear-gradient(135deg, #38bdf8, #0284c7); font-size: 16px; }
.lmsp-hero-scene .lmsp-nav { display: flex; flex-direction: column; gap: 8px; }
.lmsp-hero-scene .lmsp-tab { display: flex; align-items: center; gap: 13px; padding: 13px 18px; border-radius: 999px; font-size: 16px; font-weight: 600; transition: background .5s, color .5s, box-shadow .5s; }
.lmsp-hero-scene .lmsp-tab i { width: 18px; text-align: center; }
.lmsp-hero-scene .lmsp-tab.active { background: linear-gradient(135deg, #0ea5e9, #2563eb); color: #fff; box-shadow: 0 8px 20px rgba(14, 165, 233, .45); }

/* Main */
.lmsp-hero-scene .lmsp-main { flex: 1; min-width: 0; padding: 28px 32px; display: flex; flex-direction: column; gap: 18px; color: var(--ink); }
.lmsp-hero-scene .lmsp-head { display: flex; align-items: center; justify-content: space-between; }
.lmsp-hero-scene .lmsp-head h3 { margin: 0; font-size: 26px; font-weight: 800; color: var(--ink); }
.lmsp-hero-scene .lmsp-live { display: inline-flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 700; color: #15803d; background: #dcfce7; padding: 8px 15px; border-radius: 999px; }
.lmsp-hero-scene .lmsp-live i { width: 9px; height: 9px; border-radius: 50%; background: #22c55e; animation: lmsp-pulse 1.6s infinite; }
@keyframes lmsp-pulse { 0% { box-shadow: 0 0 0 0 rgba(34, 197, 94, .7); } 100% { box-shadow: 0 0 0 10px rgba(34, 197, 94, 0); } }
.lmsp-hero-scene .lmsp-body { position: relative; flex: 1; min-height: 0; }

/* Scenes */
.lmsp-hero-scene .lmsp-sc {
  position: absolute; inset: 0; display: grid; gap: 16px; opacity: 0; visibility: hidden;
  transform: translateY(20px) scale(.98);
  transition: opacity .8s, transform .8s cubic-bezier(.2, .8, .2, 1), visibility 0s .8s;
}
.lmsp-hero-scene .lmsp-sc.on { opacity: 1; visibility: visible; transform: none; transition-delay: 0s; }
.lmsp-hero-scene .lmsp-sc.on .st { animation: lmsp-in .7s cubic-bezier(.2, .8, .2, 1) both; animation-delay: calc(var(--i, 0)*80ms + 200ms); }
@keyframes lmsp-in { from { opacity: 0; transform: translateY(16px) scale(.96); } }
.lmsp-hero-scene .card {
  background: #fff !important; border: 1px solid var(--line) !important; border-radius: 16px !important;
  padding: 18px !important; box-shadow: 0 8px 22px rgba(10, 50, 100, .07) !important; min-width: 0; color: var(--ink) !important;
}
.lmsp-hero-scene .card h4 { margin: 0 0 12px; font-size: 15px; font-weight: 700; display: flex; justify-content: space-between; align-items: center; color: var(--ink); }
.lmsp-hero-scene .card h4 span { font-size: 12px; color: var(--mut); font-weight: 600; }
.lmsp-hero-scene small { color: var(--mut); font-weight: 600; font-size: 13px; }

/* S1 KPIs */
.lmsp-hero-scene .s1 { grid-template-columns: repeat(3, 1fr); grid-template-rows: repeat(2, 1fr); }
.lmsp-hero-scene .kpi { display: flex; flex-direction: column; justify-content: center; gap: 8px; padding: 22px !important; position: relative; overflow: hidden; }
.lmsp-hero-scene .kpi .ic { width: 42px; height: 42px; border-radius: 12px; display: grid; place-items: center; color: #fff; background: linear-gradient(135deg, #38bdf8, #0284c7); font-size: 17px; }
.lmsp-hero-scene .kpi strong { font-size: 46px; font-weight: 800; letter-spacing: -1.5px; line-height: 1; color: var(--ink); }
.lmsp-hero-scene .kpi::after { content: ""; position: absolute; right: -30px; top: -30px; width: 110px; height: 110px; border-radius: 50%; background: radial-gradient(circle, rgba(56, 189, 248, .2), transparent 70%); }

/* S2 students */
.lmsp-hero-scene .s2 { grid-template-rows: auto auto 1fr; align-content: start; }
.lmsp-hero-scene .bar { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }
.lmsp-hero-scene .search { flex: 1; min-width: 140px; display: flex; align-items: center; gap: 10px; background: #fff; border: 1px solid var(--line); border-radius: 999px; padding: 11px 18px; color: var(--mut); font-size: 14px; }
.lmsp-hero-scene .fchip { padding: 9px 16px; border-radius: 999px; background: #e8f0fb; color: #35507a; font-size: 13px; font-weight: 600; }
.lmsp-hero-scene .fchip.on { background: #0284c7; color: #fff; }
.lmsp-hero-scene .pcards { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; }
.lmsp-hero-scene .pc { display: flex; align-items: center; gap: 14px; transition: transform .5s, box-shadow .5s; }
.lmsp-hero-scene .pc.hl { transform: translateY(-5px) scale(1.03); box-shadow: 0 18px 34px rgba(2, 132, 199, .25) !important; border-color: #7dd3fc !important; }
.lmsp-hero-scene .av { width: 46px; height: 46px; flex: none; border-radius: 50%; display: grid; place-items: center; color: #fff; font-weight: 800; background: linear-gradient(135deg, #38bdf8, #2563eb); }
.lmsp-hero-scene .pc b, .lmsp-hero-scene .tr b { display: block; font-size: 15px; color: var(--ink); }
.lmsp-hero-scene .badge { display: inline-block; font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 999px; background: #dcfce7; color: #15803d; }
.lmsp-hero-scene .badge.w { background: #fef3c7; color: #b45309; }
.lmsp-hero-scene .badge.i { background: #dbeafe; color: #1d4ed8; }
.lmsp-hero-scene .tr { display: grid; grid-template-columns: 2fr 1fr 1.2fr 1fr; align-items: center; gap: 8px; padding: 11px 6px; border-bottom: 1px solid var(--line); font-size: 14px; transition: background .5s; }
.lmsp-hero-scene .tr:last-child { border: 0; }
.lmsp-hero-scene .tr.hl { background: #eef7ff; border-radius: 10px; }
.lmsp-hero-scene .tr.th { font-size: 11px; font-weight: 700; color: var(--mut); text-transform: uppercase; letter-spacing: .6px; }

/* S3 seats */
.lmsp-hero-scene .s3 { grid-template-columns: 1.25fr 1fr; }
.lmsp-hero-scene .seats { display: grid; grid-template-columns: repeat(8, 1fr); gap: 9px; }
.lmsp-hero-scene .seat { aspect-ratio: 1; border-radius: 10px; background: #0284c7; display: grid; place-items: center; color: #fff; font-size: 11px; font-weight: 700; transition: background .5s, transform .5s; }
.lmsp-hero-scene .seat.free { background: #e2f6e9; color: #15803d; border: 2px dashed #86efac; }
.lmsp-hero-scene .seat.pop { animation: lmsp-pop .8s; }
@keyframes lmsp-pop { 40% { transform: scale(1.28); box-shadow: 0 0 0 8px rgba(56, 189, 248, .35); } }
.lmsp-hero-scene .legend { display: flex; gap: 16px; margin-top: 12px; font-size: 12px; color: var(--mut); font-weight: 600; }
.lmsp-hero-scene .legend i { display: inline-block; width: 11px; height: 11px; border-radius: 4px; background: #0284c7; margin-right: 6px; vertical-align: -1px; }
.lmsp-hero-scene .legend i.f { background: #bbf7d0; }
.lmsp-hero-scene .rcol { display: flex; flex-direction: column; gap: 14px; min-height: 0; }
.lmsp-hero-scene .mini { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.lmsp-hero-scene .mini strong { display: block; font-size: 32px; font-weight: 800; letter-spacing: -1px; }
.lmsp-hero-scene .feed { flex: 1; overflow: hidden; }
.lmsp-hero-scene .fi { display: flex; align-items: center; gap: 12px; padding: 8px 0; font-size: 14px; animation: lmsp-slide .6s cubic-bezier(.2, .8, .2, 1); }
.lmsp-hero-scene .fi .av { width: 34px; height: 34px; font-size: 12px; }
@keyframes lmsp-slide { from { opacity: 0; transform: translateX(-24px); } }

/* S4 shifts & payments */
.lmsp-hero-scene .s4 { grid-template-columns: 1fr 1fr; }
.lmsp-hero-scene .shifts { display: flex; flex-direction: column; gap: 12px; }
.lmsp-hero-scene .sh { padding: 16px 18px !important; transition: transform .5s, box-shadow .5s, border-color .5s; }
.lmsp-hero-scene .sh.hl { transform: scale(1.03); box-shadow: 0 16px 30px rgba(2, 132, 199, .25) !important; border-color: #7dd3fc !important; }
.lmsp-hero-scene .sh div { display: flex; justify-content: space-between; align-items: center; font-size: 15px; font-weight: 700; }
.lmsp-hero-scene .track { height: 8px; border-radius: 9px; background: #e8f0fb; margin-top: 10px; overflow: hidden; }
.lmsp-hero-scene .fill { height: 100%; width: 0; border-radius: 9px; background: linear-gradient(90deg, #38bdf8, #0284c7); transition: width 1.3s cubic-bezier(.2, .9, .25, 1); }
.lmsp-hero-scene .big { font-size: 44px; font-weight: 800; letter-spacing: -1.5px; line-height: 1.1; }

/* Bars */
.lmsp-hero-scene .bars { display: flex; align-items: flex-end; justify-content: space-between; gap: 12px; height: 170px; padding-top: 26px; }
.lmsp-hero-scene .col { flex: 1; height: 100%; display: flex; flex-direction: column; justify-content: flex-end; align-items: center; gap: 6px; min-width: 0; }
.lmsp-hero-scene .col span { font-size: 12px; color: var(--mut); font-weight: 600; }
.lmsp-hero-scene .lb { position: relative; width: 100%; max-width: 52px; height: 0; border-radius: 10px 10px 6px 6px; background: linear-gradient(180deg, #38bdf8, #0284c7); transition: height 1.1s cubic-bezier(.2, .9, .25, 1), filter .3s; cursor: pointer; }
.lmsp-hero-scene .lb:hover { filter: brightness(1.2); }
.lmsp-hero-scene .lb::after { content: attr(data-tip); position: absolute; left: 50%; bottom: calc(100% + 8px); transform: translate(-50%, 6px); background: #07162e; color: #fff; font-size: 12px; font-weight: 600; padding: 6px 10px; border-radius: 8px; white-space: nowrap; opacity: 0; pointer-events: none; transition: .25s; z-index: 9; }
.lmsp-hero-scene .lb:hover::after { opacity: 1; transform: translate(-50%, 0); }

/* S5 analytics */
.lmsp-hero-scene .s5 { grid-template-columns: 1.4fr 1fr; grid-template-rows: 1fr 1fr; }
.lmsp-hero-scene .s5 .wk { grid-row: 1/3; display: flex; flex-direction: column; }
.lmsp-hero-scene .s5 .wk .bars { flex: 1; height: auto; min-height: 150px; }
.lmsp-hero-scene .rings { display: flex; justify-content: space-around; gap: 10px; }
.lmsp-hero-scene .ringw { text-align: center; }
.lmsp-hero-scene .ring { --p: 0; width: 96px; aspect-ratio: 1; border-radius: 50%; margin: 0 auto 6px; display: grid; place-items: center; position: relative; background: conic-gradient(#0ea5e9 calc(var(--p)*1%), #e6eefa 0); }
.lmsp-hero-scene .ring::before { content: ""; position: absolute; inset: 11px; background: #fff; border-radius: 50%; }
.lmsp-hero-scene .ring strong { position: relative; font-size: 22px; font-weight: 800; }

/* Compact Floating Chips */
.lmsp-hero-scene .lmsp-chip {
  position: absolute; display: flex; align-items: center; gap: 8px; padding: 8px 12px; border-radius: 12px;
  font-size: 11px; font-weight: 700; color: #fff; white-space: nowrap;
  background: rgba(15, 23, 42, .68); border: 1px solid rgba(125, 211, 252, .45);
  backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
  box-shadow: 0 12px 26px rgba(0, 10, 40, .4);
  animation: lmsp-float 5s ease-in-out infinite; transform: translateZ(45px); z-index: 5;
}
.lmsp-hero-scene .lmsp-chip i { width: 24px; height: 24px; border-radius: 8px; display: grid; place-items: center; font-size: 11px; background: linear-gradient(135deg, #38bdf8, #2563eb); }
.lmsp-hero-scene .c1 { top: -14px; right: -8px; }
.lmsp-hero-scene .c2 { bottom: -14px; left: -8px; animation-delay: -1.7s; }
.lmsp-hero-scene .c3 { bottom: -16px; right: 6%; animation-delay: -3.3s; }
@keyframes lmsp-float { 0%, 100% { margin-top: 0; } 50% { margin-top: -8px; } }

/* Progress Bar */
.lmsp-hero-scene .lmsp-prog { position: relative; display: flex; align-items: center; gap: 7px; width: min(360px, 90%); margin-top: 4px; }
.lmsp-hero-scene .seg { flex: 1; height: 14px; display: flex; align-items: center; background: none; border: 0; padding: 0; cursor: pointer; }
.lmsp-hero-scene .seg u { display: block; width: 100%; height: 3.5px; border-radius: 4px; background: rgba(255, 255, 255, .28); overflow: hidden; text-decoration: none; }
.lmsp-hero-scene .seg i { display: block; height: 100%; width: 0; background: #7dd3fc; }
.lmsp-hero-scene .seg.done i { width: 100%; }
.lmsp-hero-scene .seg.on i { animation: lmsp-fill var(--d, 4600ms) linear forwards; }
@keyframes lmsp-fill { to { width: 100%; } }
.lmsp-hero-scene .lmsp-label { position: relative; color: #bfe3ff; font-size: 11px; font-weight: 600; letter-spacing: .4px; margin-top: -8px; text-align: center; }

@media (max-width: 575px) {
  .lmsp-hero-scene .lmsp-chip { font-size: 10px; padding: 6px 9px; transform: none; }
  .lmsp-hero-scene .lmsp-chip i { width: 20px; height: 20px; font-size: 10px; }
  .lmsp-hero-scene .c1 { top: -10px; right: 0; }
  .lmsp-hero-scene .c2 { bottom: -10px; left: 0; }
  .lmsp-hero-scene .c3 { display: none; }
}
@media (prefers-reduced-motion: reduce) {
  .lmsp-hero-scene *, .lmsp-hero-scene::before, .lmsp-hero-scene::after { animation: none !important; }
}
</style>
@endpush

<div class="lmsp-hero-scene" id="lmspScene">
  <div class="lmsp-fx" id="lmspFx"></div>
  <div class="lmsp-stage" id="lmspStage">
    <div class="lmsp-fit" id="lmspFit">
      <div class="lmsp-window" id="lmspWin">
        <aside class="lmsp-side">
          <div class="lmsp-logo"><b><i class="fa-solid fa-book-open"></i></b><span>LMSP</span></div>
          <nav class="lmsp-nav" id="lmspNav">
            <div class="lmsp-tab"><i class="fa-solid fa-gauge-high"></i><span>Dashboard</span></div>
            <div class="lmsp-tab"><i class="fa-solid fa-clock"></i><span>Shifts</span></div>
            <div class="lmsp-tab"><i class="fa-solid fa-chair"></i><span>Seats</span></div>
            <div class="lmsp-tab"><i class="fa-solid fa-user-graduate"></i><span>Students</span></div>
            <div class="lmsp-tab"><i class="fa-solid fa-calendar-check"></i><span>Attendance</span></div>
            <div class="lmsp-tab"><i class="fa-solid fa-credit-card"></i><span>Payments</span></div>
          </nav>
        </aside>
        <main class="lmsp-main">
          <div class="lmsp-head"><h3>Welcome back, Admin 👋</h3><span class="lmsp-live"><i></i>Live</span></div>
          <div class="lmsp-body">

            <!-- Scene 1 -->
            <div class="lmsp-sc s1">
              <div class="card kpi st" style="--i:0"><span class="ic"><i class="fa-solid fa-users"></i></span><small>Total Students</small><strong data-to="250">0</strong></div>
              <div class="card kpi st" style="--i:1"><span class="ic"><i class="fa-solid fa-door-open"></i></span><small>Inside Now</small><strong data-to="142">0</strong></div>
              <div class="card kpi st" style="--i:2"><span class="ic"><i class="fa-solid fa-chart-pie"></i></span><small>Seat Utilization</small><strong data-to="88" data-suf="%">0</strong></div>
              <div class="card kpi st" style="--i:3"><span class="ic"><i class="fa-solid fa-wallet"></i></span><small>Monthly Revenue</small><strong data-to="42.5" data-dec="1" data-pre="₹" data-suf="K">0</strong></div>
              <div class="card kpi st" style="--i:4"><span class="ic"><i class="fa-solid fa-hourglass-half"></i></span><small>Expiring Soon</small><strong data-to="12">0</strong></div>
              <div class="card kpi st" style="--i:5"><span class="ic"><i class="fa-solid fa-clock"></i></span><small>Active Shifts</small><strong data-to="3">0</strong></div>
            </div>

            <!-- Scene 2 -->
            <div class="lmsp-sc s2">
              <div class="bar st" style="--i:0"><div class="search"><i class="fa-solid fa-magnifying-glass"></i>Search students…</div>
                <span class="fchip on">All</span><span class="fchip">Inside</span><span class="fchip">Expiring</span></div>
              <div class="pcards" id="lmspPc"></div>
              <div class="card st" style="--i:4"><h4>Student Records <span>250 total</span></h4><div id="lmspRows"></div></div>
            </div>

            <!-- Scene 3 -->
            <div class="lmsp-sc s3">
              <div class="card st" style="--i:0"><h4>Seat Layout <span>Live</span></h4><div class="seats" id="lmspSeats"></div>
                <div class="legend"><span><i></i>Occupied</span><span><i class="f"></i>Available</span></div></div>
              <div class="rcol">
                <div class="mini st" style="--i:2">
                  <div class="card"><small>Inside Now</small><strong data-to="142">0</strong></div>
                  <div class="card"><small>Present Today</small><strong data-to="180">0</strong></div>
                </div>
                <div class="card feed st" style="--i:3"><h4>Live Check-ins <span>Attendance</span></h4><div id="lmspFeed"></div></div>
              </div>
            </div>

            <!-- Scene 4 -->
            <div class="lmsp-sc s4">
              <div class="shifts" id="lmspShifts"></div>
              <div class="rcol">
                <div class="card st" style="--i:3"><small>Payment Collection</small><div class="big" data-to="42500" data-pre="₹" data-comma="1">0</div><small>Collected this month</small></div>
                <div class="card st" style="--i:4;flex:1"><h4>Revenue Analytics <span>₹42.5K</span></h4><div class="bars" id="lmspRev"></div></div>
              </div>
            </div>

            <!-- Scene 5 -->
            <div class="lmsp-sc s5">
              <div class="card wk st" style="--i:0"><h4>Weekly Attendance <span>Check-ins</span></h4><div class="bars" id="lmspWeek"></div></div>
              <div class="card st" style="--i:2"><h4>Presence &amp; Seats <span>Today</span></h4>
                <div class="rings">
                  <div class="ringw"><div class="ring"><strong data-to="72" data-suf="%">0</strong></div><small>Students Present</small></div>
                  <div class="ringw"><div class="ring"><strong data-to="88" data-suf="%">0</strong></div><small>Seat Utilization</small></div>
                </div></div>
              <div class="card st" style="--i:3"><small>Revenue Summary</small><div class="big" data-to="42.5" data-dec="1" data-pre="₹" data-suf="K">0</div><small>Monthly Revenue · 12 expiring soon</small></div>
            </div>

          </div>
        </main>
      </div>
    </div>
    <div class="lmsp-chip c1"><i class="fa-solid fa-user-check"></i>180 Students Present</div>
    <div class="lmsp-chip c2"><i class="fa-solid fa-clock"></i>3 Active Shifts</div>
    <div class="lmsp-chip c3"><i class="fa-solid fa-indian-rupee-sign"></i>₹42,500 Collected</div>
  </div>
  <div class="lmsp-prog" id="lmspProg"></div>
  <div class="lmsp-label" id="lmspLabel"></div>
</div>

@push('scripts')
<script>
(function(){
  var $=function(s,r){return (r||document).querySelector(s)},scene=$('#lmspScene'),stage=$('#lmspStage'),fit=$('#lmspFit'),win=$('#lmspWin');
  if(!scene) return;
  var reduce=matchMedia('(prefers-reduced-motion: reduce)').matches,D=4600;

  /* Particles */
  var fx=$('#lmspFx');for(var p=0;p<14;p++){var s=document.createElement('span'),z=2+Math.random()*3.5;
    s.style.cssText='left:'+Math.random()*100+'%;width:'+z+'px;height:'+z+'px;animation-duration:'+(9+Math.random()*12)+'s;animation-delay:-'+Math.random()*15+'s';fx.appendChild(s)}

  /* Always 16:9 (1280 x 720) smoothly scaled to container width */
  function layout(){
    var w=stage.clientWidth,W=1280,H=720,k=w/W;
    fit.style.width=W+'px';
    fit.style.height=H+'px';
    fit.style.transform='scale('+k+')';
    stage.style.height=(H*k)+'px';
  }
  layout();
  addEventListener('resize',layout);

  /* Helpers */
  var grad=['#38bdf8,#2563eb','#34d399,#0d9488','#a78bfa,#6366f1','#fb923c,#e11d48'];
  function av(n,i){return '<div class="av" style="background:linear-gradient(135deg,'+grad[i%4]+')">'+n.split(' ').map(function(x){return x[0]}).join('')+'</div>'}
  function bars(el,vals,labels,fmt,max){
    el.innerHTML=vals.map(function(v,i){return '<div class="col"><div class="lb" data-h="'+(v/max*100)+'" data-tip="'+fmt(labels[i],v)+'"></div><span>'+labels[i]+'</span></div>'}).join('')}

  /* Scene 2 data */
  var st=[['Aarav Sharma','A-14','Morning','Inside',''],['Priya Verma','B-07','Evening','Active',''],['Rohan Gupta','C-21','Afternoon','Expiring','w'],['Ananya Singh','A-03','Morning','Inside','']];
  $('#lmspPc').innerHTML=st.slice(0,3).map(function(s,i){return '<div class="card pc st" style="--i:'+(i+1)+'">'+av(s[0],i)+'<div><b>'+s[0]+'</b><span class="badge '+(s[4]||(s[3]=='Inside'?'i':''))+'">'+s[3]+'</span></div></div>'}).join('');
  $('#lmspRows').innerHTML='<div class="tr th"><span>Student</span><span>Seat</span><span>Shift</span><span>Status</span></div>'+
    st.map(function(s,i){return '<div class="tr st" style="--i:'+(i+5)+'"><b>'+s[0]+'</b><span>'+s[1]+'</span><span>'+s[2]+'</span><span><i class="badge '+(s[4]||(s[3]=='Inside'?'i':''))+'" style="font-style:normal">'+s[3]+'</i></span></div>'}).join('');

  /* Scene 3 seats + feed */
  var free=[3,11,17,26,33],seatEls=[];
  $('#lmspSeats').innerHTML=Array.from({length:40},function(_,i){return '<div class="seat st" style="--i:'+(i%8)+'">'+'ABCDE'[i>>3]+(i%8+1)+'</div>'}).join('');
  seatEls=[].slice.call(document.querySelectorAll('#lmspSeats .seat'));
  function resetSeats(){seatEls.forEach(function(e,i){e.classList.toggle('free',free.indexOf(i)>-1)})}
  var names=['Aarav S.','Priya V.','Rohan G.','Ananya S.','Kabir M.','Neha R.','Ishaan T.'],feedT,seatT,fn=0;
  function start3(){
    resetSeats();var f=$('#lmspFeed');f.innerHTML='';fn=0;
    function add(){var n=names[fn%names.length],i=fn++,d=document.createElement('div');d.className='fi';
      d.innerHTML=av(n,i)+'<div><b style="font-size:14px">'+n+' checked in</b><small>Seat '+'ABCDE'[(i*3)%5]+'-'+(i*2%8+1)+' · just now</small></div>';
      f.insertBefore(d,f.firstChild);while(f.children.length>4)f.removeChild(f.lastChild)}
    setTimeout(add,700);feedT=setInterval(add,900);
    seatT=setInterval(function(){
      var fr=seatEls.filter(function(e){return e.classList.contains('free')}),oc=seatEls.filter(function(e){return !e.classList.contains('free')});
      var a=fr[Math.random()*fr.length|0],b=oc[Math.random()*oc.length|0];
      if(a){a.classList.remove('free');a.classList.remove('pop');void a.offsetWidth;a.classList.add('pop')}
      if(b)b.classList.add('free');
    },1000);
  }
  function stop3(){clearInterval(feedT);clearInterval(seatT)}

  /* Scene 4 */
  var sh=[['Morning','6 AM – 12 PM',82],['Afternoon','12 PM – 6 PM',91],['Evening','6 PM – 11 PM',76]];
  $('#lmspShifts').innerHTML=sh.map(function(s,i){return '<div class="card sh st" style="--i:'+i+'"><div><span><i class="fa-solid fa-clock" style="color:#0284c7;margin-right:8px"></i>'+s[0]+'</span><small>'+s[1]+'</small></div><div class="track"><div class="fill" data-w="'+s[2]+'"></div></div></div>'}).join('');
  bars($('#lmspRev'),[9.4,10.2,11.1,11.8],['W1','W2','W3','W4'],function(l,v){return l+': ₹'+v+'K'},14);

  /* Scene 5 */
  var wv=[164,172,158,181,176,122,96],wd=['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
  bars($('#lmspWeek'),wv,wd,function(l,v){return l+': '+v+' Check-ins'},200);

  /* Count-up */
  function count(el){
    var to=+el.dataset.to,dec=+(el.dataset.dec||0),pre=el.dataset.pre||'',suf=el.dataset.suf||'',t0=null,ring=el.closest('.ring');
    (function step(ts){if(!t0)t0=ts+250;var p=Math.min(Math.max((ts-t0)/1300,0),1),v=to*(1-Math.pow(1-p,3)),txt=v.toFixed(dec);
      if(el.dataset.comma)txt=Math.round(v).toLocaleString('en-IN');
      el.textContent=pre+txt+suf;if(ring)ring.style.setProperty('--p',v);
      if(p<1)requestAnimationFrame(step)})(performance.now());
  }
  function enter(sc){
    sc.querySelectorAll('[data-to]').forEach(count);
    var hs=sc.querySelectorAll('[data-h],[data-w]');
    hs.forEach(function(e){e.style.transition='none';e.style.height=e.dataset.h?'0':'';e.style.width=e.dataset.w?'0':''});
    void sc.offsetWidth;
    setTimeout(function(){hs.forEach(function(e,i){setTimeout(function(){e.style.transition='';if(e.dataset.h)e.style.height=e.dataset.h+'%';if(e.dataset.w)e.style.width=e.dataset.w+'%'},i*90)})},400);
    var hl=sc.querySelectorAll('.pc,.tr:not(.th),.sh'),k=0;
    hl.forEach(function(e){e.classList.remove('hl')});
    if(hl.length){clearInterval(hlT);hlT=setInterval(function(){hl.forEach(function(e,i){e.classList.toggle('hl',i===k%hl.length)});k++},1000)}
  }
  var hlT;

  /* Scene controller */
  var sc=[].slice.call(document.querySelectorAll('.lmsp-sc')),tabs=[].slice.call(document.querySelectorAll('#lmspNav .lmsp-tab')),
      map=[[0],[3],[2,4],[1,5],[0]],
      labels=['Dashboard Overview','Student Management','Seats & Attendance','Shifts & Payments','Live Analytics'],
      prog=$('#lmspProg'),lab=$('#lmspLabel'),cur=-1,timer;
  prog.style.setProperty('--d',D+'ms');
  prog.innerHTML=labels.map(function(l,i){return '<button type="button" class="seg" aria-label="'+l+'"><u><i></i></u></button>'}).join('');
  var segs=[].slice.call(prog.children);
  segs.forEach(function(b,i){b.addEventListener('click',function(){go(i)})});
  function go(i){
    clearTimeout(timer);if(cur===2)stop3();
    sc.forEach(function(s,k){s.classList.toggle('on',k===i)});
    tabs.forEach(function(t,k){t.classList.toggle('active',map[i].indexOf(k)>-1)});
    segs.forEach(function(b,k){b.classList.remove('on');b.classList.toggle('done',k<i)});
    void prog.offsetWidth;segs[i].classList.add('on');
    lab.textContent='0'+(i+1)+' · '+labels[i];
    if(i===2)start3();
    enter(sc[i]);cur=i;timer=setTimeout(function(){go((i+1)%sc.length)},D);
  }
  go(0);

  /* Live bar pulse on analytics scene */
  setInterval(function(){
    if(reduce||cur!==4)return;
    document.querySelectorAll('#lmspWeek .lb').forEach(function(b,i){
      if(b.matches(':hover'))return;b.style.height=Math.max(15,Math.min(97,wv[i]/2+(Math.random()*7-3.5)))+'%'});
  },1400);

  /* 3D tilt (mouse) + idle float */
  var base={x:3,y:-7},tgt={x:3,y:-7},now={x:3,y:-7},last=0;
  if(matchMedia('(pointer:fine)').matches&&!reduce){
    scene.addEventListener('mousemove',function(e){var r=scene.getBoundingClientRect(),px=(e.clientX-r.left)/r.width-.5,py=(e.clientY-r.top)/r.height-.5;
      tgt.y=base.y+px*12;tgt.x=base.x-py*8;last=performance.now()});
    scene.addEventListener('mouseleave',function(){last=0});
  }
  (function frame(t){
    if(!reduce){if(t-last>1500){tgt.y=base.y+Math.sin(t/1800)*3.5;tgt.x=base.x+Math.cos(t/2300)*2}
      now.x+=(tgt.x-now.x)*.07;now.y+=(tgt.y-now.y)*.07}
    var k=innerWidth<576?.35:1;stage.style.transform='rotateX('+now.x*k+'deg) rotateY('+now.y*k+'deg)';
    requestAnimationFrame(frame);
  })(0);
})();
</script>
@endpush