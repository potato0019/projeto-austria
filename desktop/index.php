
<?php
require_once __DIR__ . '/includes/conteudo.php';
require __DIR__ . '/includes/header.php';
?>

<style>
  html {
    scroll-behavior: smooth;
    scroll-padding-top: 76px;
  }

  body {
    overflow-x: hidden;
  }

  main {
    width: 100%;
    overflow-x: clip;
  }

  .presentation-section {
    min-height: 100svh;
    scroll-snap-align: start;
    scroll-snap-stop: normal;
  }

  #timeline-scroll {
    scrollbar-width: none;
    -webkit-overflow-scrolling: touch;
  }

  #timeline-scroll::-webkit-scrollbar {
    display: none;
  }

  .reveal {
    opacity: 0;
    transform: translateY(14px);
    transition: opacity .6s ease, transform .6s ease;
  }

  .reveal.is-visible {
    opacity: 1;
    transform: translateY(0);
  }

  #legend-modal > div {
    max-height: 92dvh;
  }

  @media (max-height: 800px) and (min-width: 768px) {
    .presentation-section {
      padding-top: 5rem;
      padding-bottom: 5rem;
    }

    #identidade .identity-image {
      min-height: 220px;
    }

    #identidade article {
      padding-top: .65rem;
      padding-bottom: .65rem;
    }

    #curiosidades article {
      min-height: 250px;
    }

    #lendas article,
    #lendas button[data-open-legend] {
      min-height: 205px;
    }
  }

  @media (max-width: 767px) {
    html {
      scroll-snap-type: y proximity;
    }

    .presentation-section {
      min-height: 100svh;
    }
  }

  /* CARROSSEL DE PAISAGENS */
  .landscape-carousel {
    position: relative;
    width: 100%;
    aspect-ratio: 16 / 9;
    overflow: hidden;
    background: #21191A;
  }

  .landscape-carousel img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0;
    transition: opacity .6s ease, transform 1s ease;
  }

  .landscape-carousel img.active {
    opacity: 1;
  }

  .landscape-carousel:hover img.active {
    transform: scale(1.025);
  }

  .carousel-arrow {
    position: absolute;
    top: 50%;
    z-index: 5;
    display: flex;
    width: 42px;
    height: 42px;
    align-items: center;
    justify-content: center;
    transform: translateY(-50%);
    border: 1px solid rgba(255,255,255,.35);
    border-radius: 50%;
    background: rgba(0,0,0,.55);
    color: white;
    font-size: 23px;
    transition: .25s;
  }

  .carousel-arrow:hover {
    background: #D52B3F;
    border-color: #D52B3F;
  }

  .carousel-prev { left: 15px; }
  .carousel-next { right: 15px; }

  .carousel-dot {
    width: 9px;
    height: 9px;
    border-radius: 50%;
    background: #C9C4BE;
    transition: .3s;
  }

  .carousel-dot.active {
    width: 25px;
    border-radius: 20px;
    background: #D52B3F;
  }

  @media (max-width: 767px) {
    .landscape-carousel { aspect-ratio: 4 / 3; }
    .carousel-arrow {
      width: 36px;
      height: 36px;
    }
  }

  @media (prefers-reduced-motion: reduce) {
    *,
    *::before,
    *::after {
      animation: none !important;
      transition: none !important;
      scroll-behavior: auto !important;
    }

    .reveal {
      opacity: 1;
      transform: none;
    }
  }
</style>

<main class="w-full">

  <!-- HERO -->
  <section
    id="inicio"
    class="presentation-section hero-image relative flex min-h-svh items-center overflow-hidden bg-cover bg-center px-5 py-24 sm:px-8 md:px-12">

    <div class="absolute inset-0 bg-gradient-to-t from-night via-black/20 to-black/20"></div>

    <div class="relative mx-auto w-full max-w-[1440px]">

      <p class="mb-5 flex items-center gap-3 text-[9px] font-bold uppercase tracking-[.25em] text-white/75 sm:text-[10px] sm:tracking-[.38em]">
        <span class="h-px w-10 bg-aus"></span>
        Europa Central · Desde 976
      </p>

      <h1 class="max-w-5xl text-[clamp(2.8rem,10vw,10rem)] font-black uppercase leading-[.88] tracking-[-.075em]">
        Descubra<br>
        <span class="text-white/75">a Áustria.</span>
      </h1>

      <div class="mt-7 flex flex-col gap-6 sm:mt-9 md:flex-row md:items-end md:justify-between">

        <p class="max-w-md font-serif text-base italic leading-relaxed text-white/80 sm:text-lg md:text-xl">
          <?= site_text('hero_description', 'Entre montanhas, palácios e lendas: uma viagem pela cultura e pela história de um país fascinante.') ?>
        </p>

        <a
          href="#identidade"
          class="group inline-flex min-h-12 w-fit items-center gap-6 border border-white/60 px-5 py-3.5 text-[10px] font-bold uppercase tracking-[.18em] transition hover:bg-white hover:text-night sm:px-6">
          Explore o país
          <span class="text-base">↗</span>
        </a>

      </div>
    </div>

    <div class="absolute right-7 top-1/2 hidden -translate-y-1/2 [writing-mode:vertical-rl] text-[9px] uppercase tracking-[.35em] text-white/60 md:block">
      Viena · Alpes · História
    </div>

    <div class="absolute bottom-6 right-8 hidden text-right text-[9px] uppercase tracking-[.2em] text-white/50 md:block">
      01 / 05
    </div>

  </section>



<!-- IDENTIDADE -->
<section id="identidade" class="flex min-h-[calc(100svh-76px)] items-center bg-paper py-10 text-night sm:py-12 lg:py-14">

  <div class="mx-auto grid w-full max-w-[1440px] grid-cols-1 items-center gap-10 px-5 sm:px-8 lg:grid-cols-12 lg:gap-12 lg:px-10 xl:gap-16">

    <!-- COLUNA ESQUERDA -->
    <div class="lg:col-span-5">

      <p class="mb-5 flex items-center gap-3 text-[10px] font-bold uppercase tracking-[.32em] text-aus">
        <span class="h-px w-7 bg-aus"></span>
        01 — Identidade
      </p>

      <h2 class="max-w-[620px] text-[clamp(3rem,5vw,5.2rem)] font-black uppercase leading-[.88] tracking-[-.065em]">
        Muito além<br>
        da paisagem.
      </h2>

      <p class="mt-6 max-w-md font-serif text-base italic leading-relaxed text-night/65 sm:text-lg">
        <?= site_text('identity_description', 'A Áustria reúne símbolos, tradições e expressões culturais que atravessaram séculos e continuam presentes no cotidiano do país.') ?>
      </p>

      <!-- CARROSSEL DE PAISAGENS -->
      <div class="mt-7">

        <div class="landscape-carousel rounded-sm" id="landscape-carousel">

<img
    src="<?= site_image('carousel_1', './assets/img/paisagem1.jpg') ?>"
    alt="Paisagem dos Alpes austríacos"
    class="active"
    loading="eager">

<img
    src="<?= site_image('carousel_2', './assets/img/paisagem2.jpg') ?>"
    alt="Montanhas e lagos da Áustria"
    loading="lazy">

<img
    src="<?= site_image('carousel_3', './assets/img/paisagem3.jpg') ?>"
    alt="Paisagem natural austríaca"
    loading="lazy">

<img
    src="<?= site_image('carousel_4', './assets/img/paisagem4.jpg') ?>"
    alt="Vilarejo nas montanhas da Áustria"
    loading="lazy">

<img
    src="<?= site_image('carousel_5', './assets/img/paisagem5.jpg') ?>"
    alt="Alpes austríacos ao entardecer"
    loading="lazy">

          <button type="button" class="carousel-arrow carousel-prev" id="carousel-prev" aria-label="Imagem anterior">‹</button>
          <button type="button" class="carousel-arrow carousel-next" id="carousel-next" aria-label="Próxima imagem">›</button>

        </div>

        <div class="mt-3 flex items-center justify-between text-[9px] font-medium uppercase tracking-[.22em] text-night/45">
          <span>Áustria · Paisagens</span>

          <div class="flex items-center gap-2" id="carousel-dots">
            <button type="button" class="carousel-dot active" data-slide="0" aria-label="Ir para imagem 1"></button>
            <button type="button" class="carousel-dot" data-slide="1" aria-label="Ir para imagem 2"></button>
            <button type="button" class="carousel-dot" data-slide="2" aria-label="Ir para imagem 3"></button>
            <button type="button" class="carousel-dot" data-slide="3" aria-label="Ir para imagem 4"></button>
            <button type="button" class="carousel-dot" data-slide="4" aria-label="Ir para imagem 5"></button>
          </div>

          <span id="carousel-counter">01 / 05</span>
        </div>

      </div>

    </div>


    <!-- COLUNA DIREITA -->
    <div class="lg:col-span-7 lg:pt-8">

      <!-- CABEÇALHO DA LISTA -->
      <div class="mb-4 flex items-center justify-between border-b border-night/20 pb-4">

        <span class="text-[9px] font-bold uppercase tracking-[.25em] text-aus">
          Elementos culturais
        </span>

        <span class="text-[9px] uppercase tracking-[.2em] text-night/40">
          Símbolos de uma nação
        </span>

      </div>


      <div class="border-t">

        <!-- 01 -->
        <article class="reveal grid min-h-[68px] grid-cols-[28px_ minmax(0,1fr)] items-center gap-3 border-b border-night/20 py-4 sm:grid-cols-[36px_1fr_1.5fr] sm:gap-4">

          <span class="text-[9px] font-bold tracking-[.15em] text-aus">01</span>

          <h3 class="text-xs font-black uppercase tracking-[.07em] sm:text-sm">
            Bandeira
          </h3>

          <p class="col-span-2 text-xs leading-relaxed text-night/65 sm:col-span-1">
            Três faixas horizontais: vermelha, branca e vermelha. É uma das bandeiras mais antigas ainda em uso.
          </p>

        </article>


        <!-- 02 -->
        <article class="reveal grid min-h-[68px] grid-cols-[28px_ minmax(0,1fr)] items-center gap-3 border-b border-night/20 py-4 sm:grid-cols-[36px_1fr_1.5fr] sm:gap-4">

          <span class="text-[9px] font-bold tracking-[.15em] text-aus">02</span>

          <h3 class="text-xs font-black uppercase tracking-[.07em] sm:text-sm">
            Cores
          </h3>

          <p class="col-span-2 text-xs leading-relaxed text-night/65 sm:col-span-1">
            Vermelho e branco da bandeira; verde, azul e tons terrosos lembram os Alpes, os lagos e as cidades históricas.
          </p>

        </article>


        <!-- 03 -->
        <article class="reveal grid min-h-[68px] grid-cols-[28px_ minmax(0,1fr)] items-center gap-3 border-b border-night/20 py-4 sm:grid-cols-[36px_1fr_1.5fr] sm:gap-4">

          <span class="text-[9px] font-bold tracking-[.15em] text-aus">03</span>

          <h3 class="text-xs font-black uppercase tracking-[.07em] sm:text-sm">
            Águia federal
          </h3>

          <p class="col-span-2 text-xs leading-relaxed text-night/65 sm:col-span-1">
            Símbolo do brasão da Áustria. Representa a república e a soberania do país.
          </p>

        </article>


        <!-- 04 -->
        <article class="reveal grid min-h-[68px] grid-cols-[28px_ minmax(0,1fr)] items-center gap-3 border-b border-night/20 py-4 sm:grid-cols-[36px_1fr_1.5fr] sm:gap-4">

          <span class="text-[9px] font-bold tracking-[.15em] text-aus">04</span>

          <h3 class="text-xs font-black uppercase tracking-[.07em] sm:text-sm">
            Alpes
          </h3>

          <p class="col-span-2 text-xs leading-relaxed text-night/65 sm:col-span-1">
            Ocupam boa parte do território e são o elemento mais reconhecido da paisagem austríaca.
          </p>

        </article>


        <!-- 05 -->
        <article class="reveal grid min-h-[68px] grid-cols-[28px_ minmax(0,1fr)] items-center gap-3 border-b border-night/20 py-4 sm:grid-cols-[36px_1fr_1.5fr] sm:gap-4">

          <span class="text-[9px] font-bold tracking-[.15em] text-aus">05</span>

          <h3 class="text-xs font-black uppercase tracking-[.07em] sm:text-sm">
            Música clássica
          </h3>

          <p class="col-span-2 text-xs leading-relaxed text-night/65 sm:col-span-1">
            Mozart, Haydn e Schubert ajudam a associar a Áustria à música.
          </p>

        </article>


        <!-- 06 -->
        <article class="reveal grid min-h-[68px] grid-cols-[28px_ minmax(0,1fr)] items-center gap-3 border-b border-night/20 py-4 sm:grid-cols-[36px_1fr_1.5fr] sm:gap-4">

          <span class="text-[9px] font-bold tracking-[.15em] text-aus">06</span>

          <h3 class="text-xs font-black uppercase tracking-[.07em] sm:text-sm">
            Arquitetura
          </h3>

          <p class="col-span-2 text-xs leading-relaxed text-night/65 sm:col-span-1">
            Palácios, edifícios barrocos e construções históricas, especialmente em Viena.
          </p>

        </article>


        <!-- 07 -->
        <article class="reveal grid min-h-[68px] grid-cols-[28px_ minmax(0,1fr)] items-center gap-3 border-b border-night/20 py-4 sm:grid-cols-[36px_1fr_1.5fr] sm:gap-4">

          <span class="text-[9px] font-bold tracking-[.15em] text-aus">07</span>

          <h3 class="text-xs font-black uppercase tracking-[.07em] sm:text-sm">
            Cafés vienenses
          </h3>

          <p class="col-span-2 text-xs leading-relaxed text-night/65 sm:col-span-1">
            Lugares de encontro, leitura e conversa, parte da vida cultural da capital.
          </p>

        </article>

      </div>

    </div>

  </div>

</section>



  <!-- LENDAS -->
  <section id="lendas" class="presentation-section relative flex flex-col justify-center overflow-hidden bg-[#21191A] py-16 sm:py-20">

    <div class="legend-image absolute inset-y-0 right-0 hidden w-[42%] bg-cover bg-center opacity-25 lg:block"></div>

    <div class="relative mx-auto w-full max-w-[1440px] px-5 sm:px-8 md:px-12">

      <!-- CABEÇALHO -->
      <div class="reveal max-w-3xl">

        <p class="mb-4 text-[10px] font-bold uppercase tracking-[.32em] text-[#F0787F]">
          02 — Folclore
        </p>

        <h2 class="text-[clamp(2.35rem,6vw,4.5rem)] font-black uppercase leading-[.92] tracking-[-.06em]">
          Histórias que<br>
          não se esquecem.
        </h2>

        <p class="mt-5 max-w-lg font-serif text-base italic text-white/65 sm:text-lg">
          <?= site_text('folklore_description', 'Criaturas misteriosas, aparições e personagens que fazem parte do imaginário popular austríaco.') ?>
        </p>

      </div>


      <!-- CARDS -->
      <div class="mt-8 grid gap-3 sm:mt-10 sm:grid-cols-2 lg:grid-cols-3">

        <button
          type="button"
          data-open-legend
          data-title="Krampus"
          data-type="Criatura folclórica"
          data-location="Região dos Alpes"
          data-text="O Krampus é uma criatura lendária do folclore alpino. Com chifres, pelos escuros e aparência assustadora, ele acompanha São Nicolau nas tradições de dezembro. Enquanto São Nicolau recompensa as crianças que se comportaram bem, o Krampus representa o lado assustador dessa tradição."
          data-image="<?= site_image('krampus', 'assets/img/krampus.png') ?>"
          class="group flex min-h-[200px] w-full flex-col border border-white/15 bg-white/[.035] p-5 text-left transition duration-300 hover:-translate-y-1 hover:border-white/45 hover:bg-white/[.08] sm:min-h-[230px] sm:p-6">

          <div class="flex items-center justify-between">
            <span class="text-[9px] font-bold uppercase tracking-[.2em] text-[#F0787F]">Criatura folclórica</span>
            <span class="text-xs text-white/35">01</span>
          </div>

          <h3 class="mt-7 text-3xl font-black uppercase tracking-[-.04em]">Krampus</h3>

          <p class="mt-2 text-[10px] uppercase tracking-[.14em] text-white/45">Região dos Alpes</p>

          <div class="mt-auto flex items-center justify-between border-t border-white/15 pt-4 text-[10px] font-bold uppercase tracking-[.2em] text-white/80">
            <span>Conheça a história</span>
            <span class="text-xl transition group-hover:translate-x-1">↗</span>
          </div>

        </button>


        <button
          type="button"
          data-open-legend
          data-title="A Dama Branca"
          data-type="Lenda misteriosa"
          data-location="Castelos austríacos"
          data-text="A Dama Branca aparece em histórias e tradições de castelos da Europa Central. Sua figura é frequentemente associada a aparições misteriosas, antigas famílias nobres e acontecimentos sobrenaturais."
          data-image="<?= site_image('white_lady', 'assets/img/damabranca.jpg') ?>"
          class="group flex min-h-[200px] w-full flex-col border border-white/15 bg-white/[.035] p-5 text-left transition duration-300 hover:-translate-y-1 hover:border-white/45 hover:bg-white/[.08] sm:min-h-[230px] sm:p-6">

          <div class="flex items-center justify-between">
            <span class="text-[9px] font-bold uppercase tracking-[.2em] text-[#F0787F]">Lenda misteriosa</span>
            <span class="text-xs text-white/35">02</span>
          </div>

          <h3 class="mt-7 text-3xl font-black uppercase tracking-[-.04em]">A Dama Branca</h3>

          <p class="mt-2 text-[10px] uppercase tracking-[.14em] text-white/45">Castelos austríacos</p>

          <div class="mt-auto flex items-center justify-between border-t border-white/15 pt-4 text-[10px] font-bold uppercase tracking-[.2em] text-white/80">
            <span>Conheça a história</span>
            <span class="text-xl transition group-hover:translate-x-1">↗</span>
          </div>

        </button>


        <button
          type="button"
          data-open-legend
          data-title="Perchten"
          data-type="Tradição alpina"
          data-location="Região alpina austríaca"
          data-text="Os Perchten são personagens mascarados das tradições de inverno dos Alpes. Com máscaras elaboradas e roupas assustadoras, participam de desfiles que simbolizam a expulsão dos espíritos do inverno."
          data-image="<?= site_image('perchten', 'assets/img/bichofeio.jpg') ?>"
          class="group flex min-h-[200px] w-full flex-col border border-white/15 bg-white/[.035] p-5 text-left transition duration-300 hover:-translate-y-1 hover:border-white/45 hover:bg-white/[.08] sm:min-h-[230px] sm:p-6">

          <div class="flex items-center justify-between">
            <span class="text-[9px] font-bold uppercase tracking-[.2em] text-[#F0787F]">Tradição alpina</span>
            <span class="text-xs text-white/35">03</span>
          </div>

          <h3 class="mt-7 text-3xl font-black uppercase tracking-[-.04em]">Perchten</h3>

          <p class="mt-2 text-[10px] uppercase tracking-[.14em] text-white/45">Região alpina austríaca</p>

          <div class="mt-auto flex items-center justify-between border-t border-white/15 pt-4 text-[10px] font-bold uppercase tracking-[.2em] text-white/80">
            <span>Conheça a história</span>
            <span class="text-xl transition group-hover:translate-x-1">↗</span>
          </div>

        </button>

      </div>

      <p class="reveal mt-7 max-w-2xl font-serif text-xl italic text-white/75 sm:mt-8 sm:text-2xl">
        “Você teria coragem de encontrar o Krampus em uma noite de inverno?”
      </p>

    </div>

  </section>


  <!-- JANELA DAS LENDAS -->
  <div
    id="legend-modal"
    class="fixed inset-0 z-[100] hidden items-center justify-center overflow-y-auto bg-black/85 p-3 backdrop-blur-sm sm:p-4"
    role="dialog"
    aria-modal="true"
    aria-labelledby="legend-modal-title">

    <div class="relative max-h-[92dvh] w-full max-w-5xl overflow-y-auto overscroll-contain bg-[#F1EDE7] text-[#21191A] shadow-2xl">

      <button
        type="button"
        id="close-legend"
        aria-label="Fechar janela"
        class="absolute right-4 top-4 z-20 flex h-10 w-10 items-center justify-center bg-black/60 text-2xl text-white transition hover:bg-black">
        ×
      </button>

      <div class="grid grid-cols-1 md:grid-cols-2">

        <div class="min-h-[190px] max-h-[30dvh] bg-[#21191A] sm:min-h-[250px] md:max-h-none md:min-h-[540px]">
          <img
            id="legend-modal-image"
            src=""
            alt=""
            class="h-full min-h-[190px] max-h-[30dvh] w-full object-cover sm:min-h-[250px] md:max-h-none md:min-h-[540px]">
        </div>

        <div class="flex flex-col justify-center p-5 sm:p-8 md:p-12">

          <p id="legend-modal-type" class="text-[10px] font-bold uppercase tracking-[.3em] text-[#C52D3A]"></p>

          <h2 id="legend-modal-title" class="mt-4 text-4xl font-black uppercase leading-[.95] tracking-[-.05em] md:text-5xl"></h2>

          <p id="legend-modal-location" class="mt-3 text-[10px] font-bold uppercase tracking-[.18em] text-black/45"></p>

          <div class="my-6 h-px w-full bg-black/15"></div>

          <p id="legend-modal-text" class="font-serif text-base leading-relaxed text-black/75 sm:text-lg"></p>

          <button
            type="button"
            id="close-legend-bottom"
            class="mt-7 min-h-12 w-fit border border-black/30 px-6 py-3 text-[10px] font-bold uppercase tracking-[.2em] transition hover:bg-black hover:text-white">
            Voltar às lendas
          </button>

        </div>

      </div>

    </div>

  </div>


  <!-- CÁPSULA DO TEMPO -->
  <section id="capsula" class="presentation-section flex flex-col justify-center bg-[#E7E1D8] py-16 text-night sm:py-20">

    <div class="mx-auto w-full max-w-[1440px] px-5 sm:px-8 md:px-12">

      <div class="reveal flex flex-col justify-between gap-5 md:flex-row md:items-end">

        <div>
          <p class="mb-4 text-[10px] font-bold uppercase tracking-[.32em] text-aus">
            03 — Linha do tempo
          </p>

          <h2 class="text-[clamp(2.35rem,6vw,4.5rem)] font-black uppercase leading-[.92] tracking-[-.06em]">
            Séculos em<br>
            movimento.
          </h2>
        </div>

        <p class="max-w-sm font-serif text-base italic leading-relaxed text-night/60 sm:text-lg">
          Selecione uma data e descubra os acontecimentos que ajudaram a formar a Áustria de hoje.
        </p>

      </div>


      <!-- LINHA DO TEMPO -->
      <div
        id="timeline-scroll"
        class="mt-8 -mx-5 w-full max-w-full snap-x snap-mandatory overflow-x-auto overscroll-x-contain px-5 pb-3 touch-pan-x sm:mx-0 sm:mt-10 sm:px-0 md:snap-none">

        <div class="flex w-max min-w-full border-y border-night/20 py-2">

          <button data-year="976" data-era="Império" data-text="A região aparece como a Marca Oriental, ligada ao Sacro Império Romano-Germânico." aria-pressed="true" class="year-button min-w-[100px] snap-start border-r border-night/15 px-4 py-4 text-left text-lg font-black transition hover:bg-aus hover:text-white sm:min-w-[112px] md:min-w-[130px]">
            <span class="block text-[9px] font-bold uppercase tracking-[.18em] opacity-60">Império</span>976
          </button>

          <button data-year="1278" data-era="Império" data-text="A dinastia dos Habsburgo começa a governar os territórios austríacos." aria-pressed="false" class="year-button min-w-[100px] snap-start border-r border-night/15 px-4 py-4 text-left text-lg font-black transition hover:bg-aus hover:text-white sm:min-w-[112px] md:min-w-[130px]">
            <span class="block text-[9px] font-bold uppercase tracking-[.18em] opacity-60">Império</span>1278
          </button>

          <button data-year="1526" data-era="Império" data-text="Os Habsburgo passam a governar também a Boêmia e a Hungria, ampliando sua influência na Europa Central." aria-pressed="false" class="year-button min-w-[100px] snap-start border-r border-night/15 px-4 py-4 text-left text-lg font-black transition hover:bg-aus hover:text-white sm:min-w-[112px] md:min-w-[130px]">
            <span class="block text-[9px] font-bold uppercase tracking-[.18em] opacity-60">Império</span>1526
          </button>

          <button data-year="1804" data-era="Império" data-text="É proclamado o Império Austríaco." aria-pressed="false" class="year-button min-w-[100px] snap-start border-r border-night/15 px-4 py-4 text-left text-lg font-black transition hover:bg-aus hover:text-white sm:min-w-[112px] md:min-w-[130px]">
            <span class="block text-[9px] font-bold uppercase tracking-[.18em] opacity-60">Império</span>1804
          </button>

          <button data-year="1867" data-era="Império" data-text="Forma-se a Monarquia Austro-Húngara, reunindo diversos povos e territórios sob uma mesma monarquia." aria-pressed="false" class="year-button min-w-[100px] snap-start border-r border-night/15 px-4 py-4 text-left text-lg font-black transition hover:bg-aus hover:text-white sm:min-w-[112px] md:min-w-[130px]">
            <span class="block text-[9px] font-bold uppercase tracking-[.18em] opacity-60">Império</span>1867
          </button>

          <button data-year="1918" data-era="República" data-text="Com o fim da Primeira Guerra e da monarquia, nasce a República da Áustria." aria-pressed="false" class="year-button min-w-[100px] snap-start border-r border-night/15 px-4 py-4 text-left text-lg font-black transition hover:bg-aus hover:text-white sm:min-w-[112px] md:min-w-[130px]">
            <span class="block text-[9px] font-bold uppercase tracking-[.18em] opacity-60">República</span>1918
          </button>

          <button data-year="1938" data-era="Guerra" data-text="A Áustria é anexada pela Alemanha nazista, no episódio conhecido como Anschluss." aria-pressed="false" class="year-button min-w-[100px] snap-start border-r border-night/15 px-4 py-4 text-left text-lg font-black transition hover:bg-aus hover:text-white sm:min-w-[112px] md:min-w-[130px]">
            <span class="block text-[9px] font-bold uppercase tracking-[.18em] opacity-60">Guerra</span>1938
          </button>

          <button data-year="1945" data-era="Guerra" data-text="Termina a Segunda Guerra Mundial e a Áustria volta a ser estabelecida como república." aria-pressed="false" class="year-button min-w-[100px] snap-start border-r border-night/15 px-4 py-4 text-left text-lg font-black transition hover:bg-aus hover:text-white sm:min-w-[112px] md:min-w-[130px]">
            <span class="block text-[9px] font-bold uppercase tracking-[.18em] opacity-60">Guerra</span>1945
          </button>

          <button data-year="1955" data-era="Contemporânea" data-text="O Tratado do Estado Austríaco restaura sua independência e o país declara neutralidade permanente." aria-pressed="false" class="year-button min-w-[100px] snap-start border-r border-night/15 px-4 py-4 text-left text-lg font-black transition hover:bg-aus hover:text-white sm:min-w-[112px] md:min-w-[130px]">
            <span class="block text-[9px] font-bold uppercase tracking-[.18em] opacity-60">Contemporânea</span>1955
          </button>

          <button data-year="1995" data-era="Contemporânea" data-text="A Áustria entra na União Europeia." aria-pressed="false" class="year-button min-w-[100px] snap-start border-r border-night/15 px-4 py-4 text-left text-lg font-black transition hover:bg-aus hover:text-white sm:min-w-[112px] md:min-w-[130px]">
            <span class="block text-[9px] font-bold uppercase tracking-[.18em] opacity-60">Contemporânea</span>1995
          </button>

        </div>

      </div>


      <!-- CARTÃO DA DATA SELECIONADA -->
      <div id="tl-card" class="reveal grid gap-4 border-b border-night/20 py-7 md:grid-cols-[.7fr_2fr] md:items-end md:py-9">

        <div>
          <span class="text-[10px] font-bold uppercase tracking-[.25em] text-aus">Império</span>

          <h3 class="mt-1 text-5xl font-black tracking-[-.06em] sm:text-6xl md:text-7xl">
            976
          </h3>
        </div>

        <p class="max-w-2xl self-end font-serif text-lg leading-relaxed text-night/70 sm:text-xl">
          A região aparece como a Marca Oriental, ligada ao Sacro Império Romano-Germânico.
        </p>

      </div>

    </div>

  </section>


  <!-- VIENA -->
  <section
    id="viena"
    class="presentation-section vienna-image relative flex flex-col justify-center bg-cover bg-center py-16 sm:py-20">

    <div class="absolute inset-0 bg-night/45"></div>

    <div class="relative mx-auto w-full max-w-[1440px] px-5 sm:px-8 md:px-12">

      <div class="reveal max-w-3xl">

        <p class="mb-4 text-[10px] font-bold uppercase tracking-[.32em] text-[#F0787F]">
          04 — A capital
        </p>

        <h2 class="text-[clamp(2.35rem,6vw,4.5rem)] font-black uppercase leading-[.92] tracking-[-.06em]">
          Viena através<br>
          do tempo.
        </h2>

        <p class="mt-5 max-w-lg font-serif text-base italic text-white/75 sm:text-lg">
          <?= site_text('vienna_description', 'De um acampamento romano a uma das capitais culturais mais conhecidas da Europa.') ?>
        </p>

      </div>


      <div class="reveal mt-8 grid gap-6 border-t border-white/30 pt-6 sm:mt-10 md:grid-cols-12">

        <!-- NAVEGAÇÃO DAS ÉPOCAS -->
        <div class="-mx-5 flex snap-x gap-2 overflow-x-auto px-5 pb-3 sm:mx-0 sm:px-0 md:col-span-4 md:flex-col md:overflow-visible">

          <button data-viena="Época romana" data-text="Existia ali Vindobona, um acampamento militar romano." aria-pressed="true" class="vienna-tab min-h-11 shrink-0 snap-start whitespace-nowrap border border-white/35 bg-white px-4 py-3 text-left text-[9px] font-bold uppercase tracking-[.12em] text-night transition hover:bg-white hover:text-night sm:text-[10px]">
            Época romana
          </button>

          <button data-viena="Idade Média" data-text="Viena cresceu como cidade comercial e residência de governantes." aria-pressed="false" class="vienna-tab min-h-11 shrink-0 snap-start whitespace-nowrap border border-white/35 px-4 py-3 text-left text-[9px] font-bold uppercase tracking-[.12em] transition hover:bg-white hover:text-night sm:text-[10px]">
            Idade Média
          </button>

          <button data-viena="Império dos Habsburgo" data-text="Tornou-se um importante centro político e cultural da Europa." aria-pressed="false" class="vienna-tab min-h-11 shrink-0 snap-start whitespace-nowrap border border-white/35 px-4 py-3 text-left text-[9px] font-bold uppercase tracking-[.12em] transition hover:bg-white hover:text-night sm:text-[10px]">
            Império dos Habsburgo
          </button>

          <button data-viena="Século XIX" data-text="A construção da avenida Ringstrasse mudou a aparência da cidade, com grandes edifícios, museus e instituições." aria-pressed="false" class="vienna-tab min-h-11 shrink-0 snap-start whitespace-nowrap border border-white/35 px-4 py-3 text-left text-[9px] font-bold uppercase tracking-[.12em] transition hover:bg-white hover:text-night sm:text-[10px]">
            Século XIX
          </button>

          <button data-viena="1918" data-text="Após a queda do Império Austro-Húngaro, Viena passou a ser a capital da República da Áustria." aria-pressed="false" class="vienna-tab min-h-11 shrink-0 snap-start whitespace-nowrap border border-white/35 px-4 py-3 text-left text-[9px] font-bold uppercase tracking-[.12em] transition hover:bg-white hover:text-night sm:text-[10px]">
            1918
          </button>

          <button data-viena="1938–1945" data-text="A Áustria foi anexada pela Alemanha nazista e Viena sofreu os efeitos da Segunda Guerra." aria-pressed="false" class="vienna-tab min-h-11 shrink-0 snap-start whitespace-nowrap border border-white/35 px-4 py-3 text-left text-[9px] font-bold uppercase tracking-[.12em] transition hover:bg-white hover:text-night sm:text-[10px]">
            1938–1945
          </button>

          <button data-viena="Pós-guerra" data-text="A cidade foi reconstruída e ocupada pelas potências aliadas até 1955." aria-pressed="false" class="vienna-tab min-h-11 shrink-0 snap-start whitespace-nowrap border border-white/35 px-4 py-3 text-left text-[9px] font-bold uppercase tracking-[.12em] transition hover:bg-white hover:text-night sm:text-[10px]">
            Pós-guerra
          </button>

          <button data-viena="Viena atual" data-text="Conhecida por seus edifícios históricos, transporte público, espaços culturais e qualidade de vida." aria-pressed="false" class="vienna-tab min-h-11 shrink-0 snap-start whitespace-nowrap border border-white/35 px-4 py-3 text-left text-[9px] font-bold uppercase tracking-[.12em] transition hover:bg-white hover:text-night sm:text-[10px]">
            Viena atual
          </button>

        </div>


        <!-- CONTEÚDO DA ÉPOCA -->
        <div class="md:col-span-8 md:flex md:flex-col md:justify-center md:pl-8">

          <span class="text-[10px] uppercase tracking-[.25em] text-white/55">
            Uma cidade em transformação
          </span>

          <h3 id="v-title" class="mt-4 text-3xl font-black uppercase tracking-[-.04em] sm:text-4xl md:text-6xl">
            Época romana
          </h3>

          <p id="v-text" class="mt-4 max-w-2xl font-serif text-lg leading-relaxed text-white/80 sm:text-xl">
            Existia ali Vindobona, um acampamento militar romano.
          </p>

          <p class="mt-7 border-l-2 border-aus pl-5 font-serif text-base italic text-white/70 sm:text-lg">
            Como você imagina que Viena estará daqui a 100 anos?
          </p>

        </div>

      </div>

    </div>

  </section>


  <!-- CURIOSIDADES -->
  <section id="curiosidades" class="presentation-section flex flex-col justify-center bg-paper py-16 text-night sm:py-20">

    <div class="mx-auto w-full max-w-[1440px] px-5 sm:px-8 md:px-12">

      <div class="reveal flex flex-col justify-between gap-5 md:flex-row md:items-end">

        <div>
          <p class="mb-4 text-[10px] font-bold uppercase tracking-[.32em] text-aus">
            05 — Para descobrir
          </p>

          <h2 class="text-[clamp(2.35rem,6vw,4.5rem)] font-black uppercase leading-[.92] tracking-[-.06em]">
            Pequenos<br>
            grandes fatos.
          </h2>
        </div>

        <p class="max-w-sm font-serif text-base italic text-night/60 sm:text-lg">
          <?= site_text('curiosities_description', 'Detalhes que revelam um pouco mais da personalidade austríaca.') ?>
        </p>

      </div>


      <!-- CARDS DE CURIOSIDADES -->
      <div class="mt-8 grid gap-3 sm:mt-10 sm:gap-4 md:grid-cols-3">

        <article class="reveal group relative min-h-[260px] overflow-hidden bg-night sm:min-h-[290px]">

          <img
            src="<?= site_image('music', 'assets/img/musica-austria.jpg') ?>"
            alt="Música na Áustria"
            loading="lazy"
            class="absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-110">

          <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/10 to-black/20"></div>

          <div class="absolute inset-0 flex flex-col justify-between p-5 text-white sm:p-6">

            <div class="flex justify-between">
              <span class="text-[10px] font-bold tracking-[.2em]">01</span>
              <span class="text-2xl opacity-80">↗</span>
            </div>

            <div>
              <h3 class="text-3xl font-black uppercase tracking-[-.04em]">Música</h3>

              <p class="mt-2 max-w-sm text-sm leading-relaxed text-white/80">
                Mozart, Haydn e Schubert fazem da Áustria um símbolo da música clássica.
              </p>
            </div>

          </div>

        </article>


        <article class="reveal group relative min-h-[260px] overflow-hidden bg-night sm:min-h-[290px]">

          <img
            src="<?= site_image('cities', 'assets/img/palacio.jpg') ?>"
            alt="Cidades na Áustria"
            loading="lazy"
            class="absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-110">

          <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/10 to-black/20"></div>

          <div class="absolute inset-0 flex flex-col justify-between p-5 text-white sm:p-6">

            <div class="flex justify-between">
              <span class="text-[10px] font-bold tracking-[.2em]">02</span>
              <span class="text-2xl opacity-80">↗</span>
            </div>

            <div>
              <h3 class="text-3xl font-black uppercase tracking-[-.04em]">Cidades</h3>

              <p class="mt-2 max-w-sm text-sm leading-relaxed text-white/80">
                Viena concentra palácios barrocos, museus e a avenida Ringstrasse.
              </p>
            </div>

          </div>

        </article>


        <article class="reveal group relative min-h-[260px] overflow-hidden bg-night sm:min-h-[290px]">

          <img
            src="<?= site_image('traditions', 'assets/img/images.jpg') ?>"
            alt="Tradições na Áustria"
            loading="lazy"
            class="absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-110">

          <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/10 to-black/20"></div>

          <div class="absolute inset-0 flex flex-col justify-between p-5 text-white sm:p-6">

            <div class="flex justify-between">
              <span class="text-[10px] font-bold tracking-[.2em]">03</span>
              <span class="text-2xl opacity-80">↗</span>
            </div>

            <div>
              <h3 class="text-3xl font-black uppercase tracking-[-.04em]">Tradições</h3>

              <p class="mt-2 max-w-sm text-sm leading-relaxed text-white/80">
                Do Krampus aos Perchten, o inverno alpino tem festas marcantes.
              </p>
            </div>

          </div>

        </article>

      </div>

    </div>

  </section>

</main>


<!-- JAVASCRIPT GERAL -->
<script>
  (() => {

    const header = document.getElementById('site-header');
    const burger = document.getElementById('burger');
    const mobile = document.getElementById('mobile');

    const updateHeader = () => {
      if (header) {
        header.classList.toggle('nav-scrolled', window.scrollY > 30);
      }
    };

    updateHeader();

    window.addEventListener('scroll', updateHeader, {
      passive: true
    });


    // MENU MOBILE
    burger?.addEventListener('click', () => {

      if (!mobile) return;

      const opened = !mobile.classList.contains('hidden');

      mobile.classList.toggle('hidden');

      burger.setAttribute('aria-expanded', String(!opened));

      burger.setAttribute(
        'aria-label',
        opened ? 'Abrir menu' : 'Fechar menu'
      );

      burger.textContent = opened ? '☰' : '×';

    });


    mobile?.querySelectorAll('a').forEach(link => {

      link.addEventListener('click', () => {

        mobile.classList.add('hidden');

        burger?.setAttribute('aria-expanded', 'false');

        if (burger) burger.textContent = '☰';

      });

    });


    // ABRIR E FECHAR DETALHES ANTIGOS, SE EXISTIREM
    document.querySelectorAll('[data-legend]').forEach(button => {

      button.addEventListener('click', () => {

        const detail = button.parentElement.querySelector('.detail');

        if (!detail) return;

        const isHidden = detail.classList.toggle('hidden');

        const spans = button.querySelectorAll('span');

        if (spans[0]) {
          spans[0].textContent = isHidden
            ? 'Conheça a história'
            : 'Fechar história';
        }

        if (spans[1]) {
          spans[1].textContent = isHidden ? '+' : '−';
        }

      });

    });


    // MODAL DAS LENDAS
    const modal = document.getElementById('legend-modal');

    if (modal) {

      const image = document.getElementById('legend-modal-image');
      const title = document.getElementById('legend-modal-title');
      const type = document.getElementById('legend-modal-type');
      const location = document.getElementById('legend-modal-location');
      const description = document.getElementById('legend-modal-text');

      const closeButton = document.getElementById('close-legend');
      const closeBottom = document.getElementById('close-legend-bottom');

      let previousFocus = null;

      function openLegend(button) {

        previousFocus = button;

        title.textContent = button.dataset.title;
        type.textContent = button.dataset.type;
        location.textContent = button.dataset.location;
        description.textContent = button.dataset.text;

        image.src = button.dataset.image;
        image.alt = button.dataset.title;

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        document.body.style.overflow = 'hidden';

        closeButton.focus();

      }

      function closeLegend() {

        modal.classList.add('hidden');
        modal.classList.remove('flex');

        document.body.style.overflow = '';

        image.src = '';

        if (previousFocus) {
          previousFocus.focus();
        }

      }

      document.querySelectorAll('[data-open-legend]').forEach(button => {

        button.addEventListener('click', function() {
          openLegend(this);
        });

      });

      closeButton.addEventListener('click', closeLegend);
      closeBottom.addEventListener('click', closeLegend);

      modal.addEventListener('click', event => {

        if (event.target === modal) {
          closeLegend();
        }

      });

      document.addEventListener('keydown', event => {

        if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
          closeLegend();
        }

      });

    }


    // LINHA DO TEMPO
    const yearButtons = [...document.querySelectorAll('[data-year]')];
    const timelineCard = document.getElementById('tl-card');

    yearButtons.forEach(button => {

      button.addEventListener('click', () => {

        yearButtons.forEach(item => {
          item.setAttribute('aria-pressed', 'false');
        });

        button.setAttribute('aria-pressed', 'true');

        if (!timelineCard) return;

        timelineCard.querySelector('span').textContent = button.dataset.era;
        timelineCard.querySelector('h3').textContent = button.dataset.year;
        timelineCard.querySelector('p').textContent = button.dataset.text;

      });

    });


    // HISTÓRIA DE VIENA
    const viennaButtons = [...document.querySelectorAll('[data-viena]')];

    viennaButtons.forEach(button => {

      button.addEventListener('click', () => {

        viennaButtons.forEach(item => {

          item.classList.remove('bg-white', 'text-night');

          item.setAttribute('aria-pressed', 'false');

        });

        button.classList.add('bg-white', 'text-night');

        button.setAttribute('aria-pressed', 'true');

        document.getElementById('v-title').textContent =
          button.dataset.viena;

        document.getElementById('v-text').textContent =
          button.dataset.text;

      });

    });


    // CARROSSEL DE PAISAGENS
    const carousel = document.getElementById('landscape-carousel');

    if (carousel) {
      const slides = [...carousel.querySelectorAll('img')];
      const dots = [...document.querySelectorAll('.carousel-dot')];
      const counter = document.getElementById('carousel-counter');
      const previous = document.getElementById('carousel-prev');
      const next = document.getElementById('carousel-next');

      let currentSlide = 0;
      let carouselInterval;

      function showSlide(index) {
        currentSlide = (index + slides.length) % slides.length;

        slides.forEach((slide, i) => {
          slide.classList.toggle('active', i === currentSlide);
        });

        dots.forEach((dot, i) => {
          dot.classList.toggle('active', i === currentSlide);
        });

        if (counter) {
          counter.textContent =
            String(currentSlide + 1).padStart(2, '0') +
            ' / ' +
            String(slides.length).padStart(2, '0');
        }
      }

      function startCarousel() {
        clearInterval(carouselInterval);
        carouselInterval = setInterval(() => showSlide(currentSlide + 1), 5000);
      }

      previous?.addEventListener('click', () => {
        showSlide(currentSlide - 1);
        startCarousel();
      });

      next?.addEventListener('click', () => {
        showSlide(currentSlide + 1);
        startCarousel();
      });

      dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
          showSlide(index);
          startCarousel();
        });
      });

      carousel.addEventListener('mouseenter', () => clearInterval(carouselInterval));
      carousel.addEventListener('mouseleave', startCarousel);

      showSlide(0);
      startCarousel();
    }


    // ANIMAÇÃO DE ENTRADA
    const revealItems = document.querySelectorAll('.reveal');

    if ('IntersectionObserver' in window) {

      const observer = new IntersectionObserver(entries => {

        entries.forEach(entry => {

          if (entry.isIntersecting) {

            entry.target.classList.add('is-visible');

            observer.unobserve(entry.target);

          }

        });

      }, {
        threshold: 0.08
      });

      revealItems.forEach(item => observer.observe(item));

    } else {

      revealItems.forEach(item => {
        item.classList.add('is-visible');
      });

    }

  })();
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>
