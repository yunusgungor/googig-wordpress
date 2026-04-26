(function ($) {

    'use strict';

    $.exists = function(selector) {
        return ($(selector).length > 0);
    }
    $.noexists = function(selector) {
        return ($(selector).length < 0);
    }
    
    $('.text-component a > img').parent('a').addClass('has-img');
    $('.text-component__inner .twitter-tweet').parent('.media-wrapper').addClass('twitter-embed');

    ms_header_menu();
    ms_page_transition();
    ms_theme_mode();
    ms_menu_button();
    ms_menu_default_mobile();
    ms_excerpt_plyr();
    ms_excerpt_gallery();
    ms_search_widget();
    ms_woo_quantity();
    ms_woo_category_loop();
    ms_woo_product_image();
    ms_video_background();
    ms_case_nav();
    ms_clipboard();
    ms_custom_cursor();

    // Elementor Controllers
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/ms_gallery.default', ms_lightbox );
        elementorFrontend.hooks.addAction( 'frontend/element_ready/ms-hero.default', ms_parallax_hero );
        elementorFrontend.hooks.addAction( 'frontend/element_ready/ms_projects.default', ms_video_thumb );
        elementorFrontend.hooks.addAction( 'frontend/element_ready/ms_slider.default', ms_slider );
        elementorFrontend.hooks.addAction( 'frontend/element_ready/ms_animated_headline.default', ms_headline );
        elementorFrontend.hooks.addAction( 'frontend/element_ready/ms_text_slider.default', ms_text_slider );
        if (typeof elementor !== 'undefined' && elementorFrontend.isEditMode()) {
            // empty
        } else {
            elementorFrontend.hooks.addAction( 'frontend/element_ready/ms_projects.default', ms_load_more_btn );
        }
        elementorFrontend.hooks.addAction( 'frontend/element_ready/ms_posts.default', ms_isotope_card_grid );
        elementorFrontend.hooks.addAction( 'frontend/element_ready/ms_gallery.default', ms_masonry_gallery );
        elementorFrontend.hooks.addAction( 'frontend/element_ready/ms_text_ticker.default', ms_text_ticker );
        elementorFrontend.hooks.addAction( 'frontend/element_ready/ms_projects.default', ms_masonry_gallery );
        elementorFrontend.hooks.addAction( 'frontend/element_ready/ms_video_button.default', ms_video_button );
        elementorFrontend.hooks.addAction( 'frontend/element_ready/ms_accordion.default', ms_accordion_widget );
        elementorFrontend.hooks.addAction( 'frontend/element_ready/ms_projects.default', ms_custom_cursor_portfolio );
        elementorFrontend.hooks.addAction( 'frontend/element_ready/ms_projects.default', ms_portfolio_list );
        elementorFrontend.hooks.addAction( 'frontend/element_ready/ms_magnetic.default', ms_magnetic );
    });

    if ( typeof $scope === 'undefined' || $scope === '' ) {
        let $scope = $("body");
        ms_text_ticker($scope);
        ms_headline($scope);
    }

    // Menu Btn Open
    var menu_open = false;

    // LocomotiveScroll
    var data_scroll = $('body').attr('data-smooth-scroll'),
    smscroll = ( 'on' == data_scroll ) ? true : false;

    const locoScroll = new LocomotiveScroll({
        lenisOptions: {
            wrapper: window,
            content: document.documentElement,
            lerp: 0.15,
            duration: 1.2,
            orientation: 'vertical',
            gestureOrientation: 'vertical',
            smoothWheel: smscroll,
            smoothTouch: false,
            autoResize: true,
        },
        autoStart: false,
        scrollCallback: onScroll,            
    });
    locoScroll.start();
    $(document).ready(function(){
        requestAnimationFrame(() => {
            setTimeout(() => {
                locoScroll.start();
                locoScroll.scrollTo(0, { immediate: true }); // Принудительное обновление позиции и прогресса
            }, 100);
        });

    });

    $(document).ready(function () {
        $('.btn[href^="#"]').addClass('anchor-link');
        $('.anchor-link').on('click', function (e) {
            e.preventDefault();
            let targetId = $(this).attr('href');
            let $target = $(targetId);
            if ($target.length) {
                locoScroll.scrollTo($target[0]);
            }
        });
    });

    // Single post page padding fixed
    jQuery(document).ready(function ($) {
        var $main = $("main.ms-main.ms-single-post");
        var $comments = $main.find(".ms-section__comments");
      
        if ($main.length && $comments.length) {
          var $next = $main.next();
      
            if (!$next.length || !$next.hasClass("ms-footer")) {
            // Либо следующий элемент отсутствует, либо это НЕ .ms-footer
            $comments.css("padding-bottom", "80px");
            } else {
            // Следующий элемент — .ms-footer
            $comments.css("padding-bottom", "0");
            }
        }
    });

    // Menu show/hide
    let isAnimating = false;
    let menuAnimation;

    function showMenu() {

        const menuWidth = $('.container-menu').outerWidth();
        const $menuInner = $('.main-header__inner');

        if (!$menuInner.hasClass('move')) {
            isAnimating = true;
            $menuInner.addClass('move');

            if (menuAnimation) menuAnimation.kill();

            menuAnimation = gsap.timeline({ onComplete: () => { isAnimating = false; } });

            menuAnimation
                .to('#primary-menu-default > li.menu-item', {
                    autoAlpha: 0,
                    x: -35,
                    duration: .3,
                    stagger: { each: 0.03, from: 'start' },
                    ease: 'power2.out',
                }, 0)
                .fromTo('.main-header__btn',
                    { width: '0%' },
                    { width: menuWidth, ease: 'power2.out', duration: 0.4 },
                0)
                .fromTo('.ms-ma-bg',
                    { scale: 0, transformOrigin: 'center' },
                    { scale: 1, duration: 0.8, ease: 'elastic.out(1.3, 0.9)' },
                0.15)
                .fromTo('.action-menu',
                    { autoAlpha: 0 },
                    { autoAlpha: 1, ease: 'power2.out', duration: 0.5 },
                0.15);
        }
    }

    function hideMenu() {
        const menuWidth = $('.container-menu').outerWidth();
        const $menuInner = $('.main-header__inner');

        if ($menuInner.hasClass('move')) {
            isAnimating = true;
            

            if (menuAnimation) menuAnimation.kill();

            menuAnimation = gsap.timeline({ onComplete: () => { isAnimating = false; } });

            menuAnimation
                .fromTo('.action-menu',
                    { autoAlpha: 1 },
                    { autoAlpha: 0, ease: 'power2.out', duration: 0.1 },
                0)
                .fromTo('.ms-ma-bg',
                    { scale: 1, transformOrigin: 'right' },
                    { scale: 0, duration: 0.4, ease: 'power2.out' },
                0)
                .fromTo('.main-header__btn',
                    { width: menuWidth },
                    { width: '0', ease: 'power2.out', duration: 0.6 },
                0.15)
                .fromTo('#primary-menu-default > li.menu-item',
                    { autoAlpha: 0, x: -35 },
                    { autoAlpha: 1, x: 0, duration: .8, stagger: { each: 0.05, from: 'end' }, ease: 'power2.out' },
                0.15);

            $menuInner.removeClass('move');
        }
    }

    function onScroll({ scroll, progress }) {
        // btt button

        if ($.exists('.back-to-top')) {
            const backToTop = document.querySelector(".back-to-top");
            const visibilityClass = 'active';
            if (scroll > 300) {
                backToTop.classList.add(visibilityClass);
            } else {
                backToTop.classList.remove(visibilityClass);
            }
        }
    
        // fixed menu
        let lastScroll = $(window).scrollTop();
        const isFixedMenu = $('body').data('menu') === 'fixed';
    
        const handleMenuAnimation = () => {

            if ($(window).width() <= 1023) {
                showMenu();
                return;
                
            }

            const scroll = $(window).scrollTop();
            const isScrollingDown = scroll > lastScroll;
    
            lastScroll = scroll;
        
            if (isFixedMenu) {
                if ((scroll > 50 && isScrollingDown) || scroll > 0) {
                    showMenu();
                } else {
                    hideMenu();
                }
            }


        };

        $(window).on('scroll', handleMenuAnimation);
    }

    let isMobileView = null;

    $(window).on('resize', function () {
        if ($(window).width() <= 1023) {
            if (isMobileView !== true) {
                isMobileView = true;
                showMenu();
            }
        } else {
            if (isMobileView !== false) {
                isMobileView = false;
                hideMenu();
            }
        }
    }).trigger('resize');

    function ms_headline($scope) {
        
        Splitting();

        const element = $scope.find('.ms-ah-wrapper');
        const el_title = element.find('.content__title');

        if ( element.has("splitting") ) {
            $('.content__title').css('opacity', '1');
        }

        const fx1Titles = element.find('.content__title[data-splitting][data-effect1]').get();
        const fx2Titles = element.find('.content__title[data-splitting][data-effect2]').get();
        const fx3Titles = element.find('.content__title[data-splitting][data-effect3]').get();
        const fx4Titles = element.find('.content__title[data-splitting][data-effect4]').get();
        const fx5Titles = element.find('.content__title[data-splitting][data-effect5]').get();
        const fx6Titles = element.find('.content__title[data-splitting][data-effect6]').get();


        function scrolltrigger(animation) {

            if ( el_title.attr('data-scroll') == 'off' ) {
                if ($('body').hasClass('transition-effect')){
                    var del_time = '1400';
                } else {
                    var del_time = '0';
                }
                animation.scrollTrigger.disable();
                $( document ).ready(function() {
                    setTimeout(function() {
                        animation.play();
                   }, del_time);
                });
            } else {
                animation.scrollTrigger.enable();
            }
        }

        fx1Titles.forEach(title => {

            const words = title.querySelectorAll('.word');
    
            for (const word of words) {

                const chars = word.querySelectorAll('.char');

                chars.forEach(char => gsap.set(char.parentNode, { perspective: 2000 })); 
    
                const animation = gsap.fromTo(chars, { 
                    'will-change': 'opacity, transform', 
                    transformOrigin: '100% 50%',
                    alpha: 0, 
                    rotationY: -90,
                    z: -300
                },
                {
                    ease: 'expo',
                    alpha: 1,
                    rotationY: 0,
                    z: 0,
                    duration: 3,
                    stagger: { each: 0.06, from: 'end'},
                    scrollTrigger: {
                        trigger: word,
                        start: 'bottom bottom',
                        end: 'top top',
                        scrub: true,
                    },
                });
                scrolltrigger(animation);
            }

        });

        fx2Titles.forEach(title => {
        
            const words = title.querySelectorAll('.word');
            
            for (const word of words) {
    
                const chars = word.querySelectorAll('.char');
    
                chars.forEach(char => gsap.set(char.parentNode, { perspective: 2000 })); 
    
                const animation = gsap.fromTo(chars, { 
                    'will-change': 'opacity, transform', 
                    autoAlpha: 0, 
                    rotationX: -90,
                    yPercent: 50
                },
                {
                    ease: 'power1.inOut',
                    autoAlpha: 1,
                    rotationX: 0,
                    yPercent: 0,
                    stagger: {
                        each: 0.03,
                        from: 0
                    },
                    scrollTrigger: {
                        trigger: word,
                        duration: 3,
                        start: 'center bottom+=20%',
                        end: 'bottom center',
                        scrub: true,
                    }
                });
                scrolltrigger(animation);
            }
    
        });

        fx3Titles.forEach(title => {
           
            const animation = gsap.fromTo(title.querySelectorAll('.word'), {
                'will-change': 'opacity',
                opacity: 0.05
            }, 
            {
                ease: 'none',
                opacity: 1,
                stagger: 0.15,
                scrollTrigger: {
                    trigger: title,
                    start: 'top 100%',
                    end: 'top 50%',
                    scrub: true,
                    
                }
            });
            
            scrolltrigger(animation);
    
        });
    
        fx4Titles.forEach(title => {
        
            const chars = title.querySelectorAll('.char');
        
            chars.forEach(char => gsap.set(char.parentNode, { perspective: 1000 })); 
            
            const animation = gsap.fromTo(chars, { 
                'will-change': 'opacity, transform', 
                autoAlpha: 0,
                rotateX: () => gsap.utils.random(-120,120),
                z: () => gsap.utils.random(-200,200),
            }, 
            {
                ease: 'none',
                autoAlpha: 1,
                rotateX: 0,
                z: 0,
                stagger: 0.02,
                scrollTrigger: {
                    trigger: title,
                    duration: 3,
                    start: 'top bottom',
                    end: 'bottom top+=25%',
                    scrub: true,
                }
            });
            scrolltrigger(animation);
        });

        fx5Titles.forEach(title => {
        
            if ( $('body').attr('data-smooth-scroll') === 'on') {
                var ease_dynamic = 'sine.Out';
            } else {
                var ease_dynamic = 'expo';
            }

            const chars = title.querySelectorAll('.char');
            
            chars.forEach(char => gsap.set(char.parentNode, { perspective: 1000 })); 
            
            const animation = gsap.fromTo(chars, {
                'will-change': 'opacity, transform', 
                transformOrigin: '50% 0%',
                opacity: 0,
                rotationX: -90,
                z: -200,
                duration: 1,
            }, 
            {
                ease: ease_dynamic,
                opacity: 1,
                stagger: 0.05,
                rotationX: 0,
                z: 0,
                scrollTrigger: {
                    trigger: title,
                    start: 'center bottom',
                    end: 'bottom top+=40%',
                    scrub: true,
                }
            });
            scrolltrigger(animation);
        });
    
        fx6Titles.forEach(title => {
            
            const words = [...title.querySelectorAll('.word')];
            
            for (const word of words) {
    
                const chars = word.querySelectorAll('.char');
                const charsTotal = chars.length;
                
                const animation = gsap.fromTo(chars, {
                    'will-change': 'transform, filter', 
                    transformOrigin: '50% 100%',
                    scale: position => {
                        const factor = position < Math.ceil(charsTotal/2) ? position : Math.ceil(charsTotal/2) - Math.abs(Math.floor(charsTotal/2) - position) - 1;
                        return gsap.utils.mapRange(0, Math.ceil(charsTotal/2), 0.5, 2.1, factor);
                    },
                    y: position => {
                        const factor = position < Math.ceil(charsTotal/2) ? position : Math.ceil(charsTotal/2) - Math.abs(Math.floor(charsTotal/2) - position) - 1;
                        return gsap.utils.mapRange(0, Math.ceil(charsTotal/2), 0, 60, factor);
                    },
                    rotation: position => {
                        const factor = position < Math.ceil(charsTotal/2) ? position : Math.ceil(charsTotal/2) - Math.abs(Math.floor(charsTotal/2) - position) - 1;
                        return position < charsTotal/2 ? gsap.utils.mapRange(0, Math.ceil(charsTotal/2), -4, 0, factor) : gsap.utils.mapRange(0, Math.ceil(charsTotal/2), 0, 4, factor);
                    },
                    filter: 'blur(12px) opacity(0)',
                }, 
                {
                    ease: 'power2.inOut',
                    y: 0,
                    rotation: 0,
                    scale: 1,
                    duration: 1,
                    filter: 'blur(0px) opacity(1)',
                    scrollTrigger: {
                        trigger: word,
                        start: 'top bottom+=20%',
                        end: 'top top+=25%',
                        scrub: true,
                    },
                    stagger: {
                        amount: 0.15,
                        from: 'center'
                    }
                });
                scrolltrigger(animation);
            }
    
        });
        
    }

    function ms_text_slider($scope) {
    const $wrap   = $scope.find('.ms-text-slider');
    const words   = $scope.find('.word').toArray();
    const word_s  = parseFloat($wrap.attr('data-speed'))   // в секундах
    const word_d  = parseFloat($wrap.attr('data-delay')) || 2000;  // в мс

    // Задаём начальные стили
    const word_h = $wrap.find('.word').outerHeight();
    $wrap.css('height', word_h);
    gsap.set(words, {
        rotateX: -90,
        opacity:  0,
        transformOrigin: '50% 50% -50px'
    });

    let currentIndex = 0;
    let timeoutId, tl;
    let isAnimating = false;

    // Показываем первое слово сразу
    gsap.set(words[0], { rotateX: 0, opacity: 1 });
    updateParentSize(words[0]);

    // Подводит обёртку под размеры слова
    function updateParentSize(el) {
        const $el = $(el);
        gsap.to($wrap, {
        width:  $el.outerWidth(),
        height: $el.outerHeight(),
        duration: 0.5,
        ease:     'Quad.easeInOut'
        });
    }

    function animateCurrentAndNextWord() {
        if (isAnimating) return;           // если анимация уже идёт — выходим
        if (document.hidden) return;       // если вкладка свернута — тоже выходим

        isAnimating = true;
        const curr = words[currentIndex];
        const next = words[(currentIndex + 1) % words.length];

        // Убиваем предыдущий таймлайн и таймаут, если они были
        if (tl)    tl.kill();
        if (timeoutId) clearTimeout(timeoutId);

        // Подгоним wrap под текущее слово
        updateParentSize(curr);
        // Подготовим следующее слово
        gsap.set(next, { rotateX: -90, opacity: 0 });

        // Запускаем новый таймлайн
        tl = gsap.timeline({
        onComplete() {
            isAnimating = false;
            currentIndex = (currentIndex + 1) % words.length;
            // Запланируем следующий цикл
            timeoutId = setTimeout(animateCurrentAndNextWord, word_d);
        }
        });

        tl
        .to(curr, {
            rotateX:  90,
            opacity:  0,
            duration: word_s,
            ease:     'Quad.easeInOut'
        })
        .to(next, {
            rotateX:  0,
            opacity:  1,
            duration: word_s,
            ease:     'Quad.easeInOut',
            onStart:  () => updateParentSize(next)
        }, `-=${word_s}`);
    }

    // Слушаем изменение видимости вкладки
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
        // убираем любые отложенные вызовы/анимации
        clearTimeout(timeoutId);
        if (tl) tl.kill();
        isAnimating = false;
        } else {
        // при возврате сразу начинаем с того, что нужно
        animateCurrentAndNextWord();
        }
    });

    // Стартовый запуск
    animateCurrentAndNextWord();
    }


    function ms_text_ticker($scope) {

        const el_wrap = $scope.find('.ms-tt-wrap').not('.ms-tt-wrap .ms-tt-wrap');

        if (!el_wrap.length) return;
        
        el_wrap.each(function() {
            const $wrap = $(this);
            if ($wrap.parent().closest('.ms-tt-wrap').length) return;
            const $ticker = $wrap.find('.ms-tt').first();
            if (!$ticker.length) return;
            const hasScrollDependency = $wrap[0].hasAttribute('data-scroll-css-progress');

            if (hasScrollDependency) {
                $wrap.addClass('s-d');
            } else {
                const tickerWidth = $ticker[0].offsetWidth;
                const speed = parseFloat($wrap.attr('data-speed')) || 1;
                const duration = tickerWidth / (100 * speed);
                $wrap[0].style.setProperty('--ticker-duration', duration + 's');
                $wrap.addClass('ticker-active');
            }
        });

    }

    function ms_video_background() {

        if ($.exists('[data-vbg]')) {
            const firstElement = $('[data-vbg]');
            firstElement.youtube_background({
                mute: true,
                fitToBackground: true,
            });
        }

    }

    function ms_search_widget() {

        $(document).ready(function () {
            const $modal = $('.header__search-modal');
            const $searchField = $modal.find('input.search-field');
        
            function toggleSearchModal() {
                $modal.toggleClass('modal--is-visible');
                if ($modal.hasClass('modal--is-visible')) {
                    $searchField.focus();
                }
            }
        
            $('.header__search-icon').on('click', toggleSearchModal);
        
            $(document).on('click', function (e) {
                if ($modal.hasClass('modal--is-visible') && e.target === $modal[0]) {
                    toggleSearchModal();
                }
            });

            $('.header__search--close-btn').on('click', toggleSearchModal);
        });

    }

    function ms_woo_product_image() {  

        $('[data-fancybox]').on('click', function(e) {
            e.preventDefault();
            
        });
        $('[data-fancybox]').magnificPopup({
            mainClass: 'mfp-fade',
            tClose: 'Fechar (Esc)',
            tLoading: '',
            type: 'image',
            image: {
               titleSrc: function(item) {
                  return item.el.attr("title");;
               }
            },
            gallery: {
                enabled:true,
                preload: [0,2],
            },

            mainClass: 'mfp-zoom-in',
            removalDelay: 300, //delay removal by X to allow out-animation
            callbacks: {
                beforeOpen: function() {
                    $('#portfolio a').each(function(){
                        $(this).attr('alt', $(this).find('img').attr('alt'));
                    }); 
                },
                open: function() {
                    //overwrite default prev + next function. Add timeout for css3 crossfade animation
                    $.magnificPopup.instance.next = function() {
                        var self = this;
                        self.wrap.removeClass('mfp-image-loaded');
                        setTimeout(function() { $.magnificPopup.proto.next.call(self); }, 120);
                    }
                    $.magnificPopup.instance.prev = function() {
                        var self = this;
                        self.wrap.removeClass('mfp-image-loaded');
                        setTimeout(function() { $.magnificPopup.proto.prev.call(self); }, 120);
                    }
                },
                imageLoadComplete: function() { 
                    var self = this;
                    setTimeout(function() { self.wrap.addClass('mfp-image-loaded'); }, 16);
                }
            }

        });
    }

    function ms_excerpt_plyr() {
        var player = new Plyr('.ms-player'),
            v_player = new Plyr('.ms-video-player');

            $('.wp-block-video').each(function() {

                var videoPlayer = new Plyr($(this).find('video'), {
                    tooltips: {
                        controls: true,
                        seek: true
                    }
                });
          
            });
            $('.wp-block-audio').each(function() {

                var audioPlayer = new Plyr($(this).find('audio'), {
                    tooltips: {
                        controls: true,
                        seek: true
                    }
                });
          
            });
    }

    function ms_excerpt_gallery() {
        if ($.exists('.ms-post-media__gallery')) {
            const swiper = new Swiper('.ms-post-media__gallery', {
                loop: true,
                speed: 600,
                navigation: {
                    nextEl: '.ms-sp-btn__next',
                    prevEl: '.ms-sp-btn__prev',
                },
            });
        }

    }

    function ms_header_menu() {
        if ($.exists('.js-main-header__nav-trigger')) {
            var mainHeader = document.getElementsByClassName('js-main-header')[0];
            if( mainHeader ) {
                var trigger = mainHeader.getElementsByClassName('js-main-header__nav-trigger')[0],
                    nav = mainHeader.getElementsByClassName('js-main-header__nav')[0];
                    //detect click on nav trigger
                    trigger.addEventListener("click", function(event) {
                        event.preventDefault();
                        var ariaExpanded = !Util.hasClass(nav, 'main-header__nav--is-visible');
                        Util.toggleClass(nav, 'main-header__nav--is-visible', ariaExpanded);
                        trigger.setAttribute('aria-expanded', ariaExpanded);
                        if(ariaExpanded) { //opening menu -> move focus to first element inside nav
                            nav.querySelectorAll('[href], input:not([disabled]), button:not([disabled])')[0].focus();
                        }
                    });
            }
        }
        if ( $(window).width() > 1023 ){
          
            // Default Menu Style
            if ($.exists('.main-header')) {
                var m_item = $('.navbar-nav').find(' > li.menu-item > a');

                $(m_item).each(function() {
                    $(this).html('<span>' + this.textContent + '</span>');
                    $(this).attr("title", this.textContent);
                });

                var menu_type = $("body").attr('data-menu');
                if (menu_type == 'fixed') {
                    var header = $(".main-header__layout").addClass('top');
                    $(window).scroll(function() {    
                        var scroll = $(window).scrollTop();
                    
                        if (scroll > 300) {
                            header.removeClass('top').addClass("action");
                        } else {
                            header.addClass('top').removeClass("action");
                        }
                    });
                }

            }

        }

    }
    
    // Osty menu button
    function ms_menu_button() {
        if ($('#primary-menu-button').find('.menu-title').length) {
            // do action
        } else {
            $('#primary-menu-button').prepend('<li class="menu-title"><a>Menu</a></li>');
        }
    
        $(window).load(function () {
            var el_wrap = $('.ms-menu-container'),
                el_wrap_bg = $('.main-header__btn .ms-ma-bg'),
                el = $('#primary-menu-button'),
                el_child_link = el.find('.menu-item-has-children > a'),
                submenuClicked = '1',
                next_width = el.outerWidth(),
                next_height = el.outerHeight(),
                close_width = $('.container-menu').outerWidth(),
                close_height = $('.container-menu').outerHeight();
    
            el.css({ 'width': next_width + 'px', 'height': next_height + 'px' });
            el_wrap_bg.css({ 'width': close_width + 'px', 'height': close_height + 'px' });
    
            // Флаг, отслеживающий состояние меню
            let menu_open = false;
            let scrollAnimating = false;
    
            function toggleMenu() {
                if (!menu_open) {
                    openMenu();
                } else {
                    closeMenu();
                }
            }
    
            function openMenu() {
                menu_open = true;
                gsap.to(el_wrap_bg, { width: next_width, height: next_height, ease: "power2.inOut" });
                $('.ms-menu-wrapper').addClass('open');
                $('.action-menu').addClass('active');
                el.addClass('show');
            }
    
            function closeMenu() {
                menu_open = false;
                $('.ms-menu-wrapper').removeClass('open');
                $('.action-menu').removeClass('active');
                $('.close-menu-bg').removeClass('show');
                $('.sub-menu').removeClass('show');
                $('.menu-back').trigger("click");
                gsap.to(el_wrap_bg, { width: close_width, height: close_height, ease: "power2.inOut" });
                
                gsap.to(el, { xPercent: 0, ease: "power2.inOut" });
                submenuClicked = '1';
            }
    
            $('.action-menu, .close-menu-bg').on('click', toggleMenu);
    
            $(window).on('scroll', function () {
                if (menu_open) {
                    closeMenu();
                }
                // Old
                if (!scrollAnimating) {
                    scrollAnimating = true;
                    // closeMenu();
                    // gsap.to(el_wrap_bg, { width: close_width, height: close_height, ease: "power2.inOut", onComplete: () => scrollAnimating = false });
                }
            });
    
            function menuIn(child) {
                $('.navbar-nav, .sub-menu').removeClass('show');
                child.children('.sub-menu').addClass('show');
                gsap.to(el_wrap, { width: next_width, height: next_height, ease: "power2.inOut" });
                gsap.to(el_wrap_bg, { width: next_width, height: next_height, ease: "power2.inOut" });
                gsap.to(el, { xPercent: '-=100', ease: "power2.inOut" });
            }
    
            el_child_link.on('click', function (e) {
                e.preventDefault();
                var child = $(this).parent();
                next_width = child.find('>.sub-menu').outerWidth();
                next_height = child.find('>.sub-menu').outerHeight();
                if (submenuClicked === '1') {
                    submenuClicked = '2';
                } else if (submenuClicked === '2') {
                    el = child.parent();
                    submenuClicked = '3';
                }
                menuIn(child);
            });
    
            $('#primary-menu-button .sub-menu').prepend('<li class="menu-back"><a>Back</a></li>');
            $('.menu-back').on('click', function (e) {
                e.preventDefault();
                var child_back = $(this);
                menuOut(child_back);
    
                if (submenuClicked === '2') {
                    submenuClicked = '1';
                    gsap.to(el, { xPercent: '+=100', ease: "power2.inOut" });
                } else if (submenuClicked === '3') {
                    submenuClicked = '2';
                    gsap.to(el, { xPercent: '+=100', ease: "power2.inOut" });
                    el = $('#primary-menu-button');
                }
            });
    
            function menuOut(child_back) {
                var parent_back = child_back.parent();
                next_width = parent_back.parent('.menu-item').parent().outerWidth();
                next_height = parent_back.parent('.menu-item').parent().outerHeight();
                parent_back.removeClass('show');
                parent_back.parent().parent().addClass('show');
                parent_back.parent('.navbar-nav, .sub-menu').removeClass('show');
                parent_back.parent('.sub-menu').removeClass('show');
                gsap.to(el_wrap, { width: next_width, height: next_height, ease: "power2.inOut" });
                gsap.to(el_wrap_bg, { width: next_width, height: next_height, ease: "power2.inOut" });
            }
        });
    }
    
    // Mobile Menu
    function ms_menu_default_mobile() {

        if ($(window).width() < 1024) {
            $('.main-header__nav ').addClass('is_mobile');
        }
    
        var isAbove1024 = $(window).width() > 1024;
        $(window).on('resize', function(event){
            if( $(window).width() < 1077 && isAbove1024){
                isAbove1024 = false;
                $('.sub-menu').css('display', 'none');
                $('.main-header__nav ').addClass('is_mobile');
            }else if($(window).width() > 1077 && !isAbove1024){
                isAbove1024 = true;
                $('.sub-menu').css('display', 'block');
                $('.main-header__nav ').removeClass('is_mobile');
            }
        });

        $(document).on('click', '.is_mobile .navbar-nav > .menu-item-has-children > a', function(e) {
            e.preventDefault();
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
                $(this).siblings('.sub-menu').slideUp(300);
            } else {
                $('.menu-item-has-children > a').removeClass('active');
                $(this).addClass('active');
                $('.sub-menu').slideUp(200);
                $(this).siblings('.sub-menu').slideDown(300);
            }
          });

          $(document).on('click', '.is_mobile .sub-menu > .menu-item-has-children > a', function(e) {
            e.preventDefault();
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
                $(this).siblings('.sub-menu').slideUp(300);
            } else {
                $('.sub-menu > .menu-item-has-children > a').removeClass("active");
                $(this).addClass('active');
                $(this).siblings('.sub-menu').slideUp(200);
                $(this).siblings('.sub-menu').slideDown(300);
            }
          });
    }
    
    // Page Transition
    function ms_page_transition() {

        if ($.exists('#loaded')) {

            $('body').addClass('transition-effect');

            window.onpageshow = function (event) {
                if (event.persisted) {
                    window.location.reload();
                }
            };

            window.onbeforeunload = function(){
                $('#loaded').css('display', 'block');
                $('body').removeClass('lazy-load');
                gsap.to("#loaded",{ opacity:1, ease: "power4.inOut", duration:.3 });
            };

            function ms_page_loaded() {
                $('#loaded').css('display', 'none');
                $('body').attr('onunload','');
                $('body').addClass('lazy-load');
            }
            gsap.fromTo("#loaded",{opacity: 1}, {opacity: 0, ease: Power1.easeOut, onComplete:ms_page_loaded, duration: .3, delay: 1 });
            
        } else {
            $('body').addClass('no-transition-effect');
        }

    }

    // Portfolio Video Thumb
    function ms_video_thumb($scope) {
        
        const el = $scope.find('.item--inner');
        const hasAutoplay = el.find('video').prop('autoplay');
        if (hasAutoplay) {
            // index
            let ms_clip = el.find('video');
            if ($.exists(ms_clip)) {
                ms_clip.get(0).play();
            };
        } else {
            //play video on hover
            $(el).on('mouseover', function() {
                let ms_clip = $(this).find('video');
                if ($.exists(ms_clip)) {
                    ms_clip.get(0).play(); 
                };
            }); 

            //pause video on mouse leave
            $(el).on('mouseleave', function() {
                let ms_clip = $(this).find('video');
                if ($.exists(ms_clip)) {
                    ms_clip.get(0).pause();
                    setTimeout(function(){ ms_clip.get(0).currentTime = 0; }, 400);
                };
            });
        }

    }

    // Custom Cursor Portfolio
    function ms_custom_cursor_portfolio($scope) {

        if (window.innerWidth <= 1440) return;
        
        if ($.exists('.cursor-custom')) {
            if (!$(".ms-cc_p")[0]) {
                var html = `
                    <div class="ms-cc_p">
                        <div class="cursor-view">
                            <div class="cursor-text-holder">
                                <div class="cursor-text"></div>
                            </div>
                        </div>
                    </div>`;
                $('body').append(html);
            }
        
            const cursorArea = $scope.find('.cursor-custom');
            const el = $scope.find('.portfolio-feed');
            const elText = el.attr('data-hover-text');
        
            gsap.set(".ms-cc_p", { xPercent: -50, yPercent: -50, scale: 1 });
        
            const ball = document.querySelector(".ms-cc_p");
            let pos = { x: window.innerWidth / 2, y: window.innerHeight / 2 };
            const mouse = { x: pos.x, y: pos.y };
            let lastMouse = { x: mouse.x, y: mouse.y };
            let speed = 1;
            const speedFactor = 0.01; // Коэффициент чувствительности для изменения scale
            const xSet = gsap.quickSetter(ball, "x", "px");
            const ySet = gsap.quickSetter(ball, "y", "px");
        
            let scaleResetTimeout;
        
            window.addEventListener("mousemove", e => {
                mouse.x = e.x;
                mouse.y = e.y;
        
                const dx = Math.abs(mouse.x - lastMouse.x);
                const dy = Math.abs(mouse.y - lastMouse.y);
                const distance = Math.sqrt(dx * dx + dy * dy);
        
                lastMouse.x = mouse.x;
                lastMouse.y = mouse.y;
        
                const dynamicScale = Math.min(1, .9 - distance * speedFactor);
                if (distance > 5) {
                    gsap.to(ball, {
                        scale: dynamicScale,
                        duration: 0.3,
                        ease: "power3.out"
                    });
                }

                clearTimeout(scaleResetTimeout);
        
                scaleResetTimeout = setTimeout(() => {
                    gsap.to(ball, {
                        scale: 1,
                        duration: 1,
                        ease: "power3.out"
                    });
                }, 100);
            });
        
            $('.cursor-text').text(elText);
        
            let tickerFunction = null;
        
            cursorArea.each((index, item) => {
                const $this = $(item);
                
                $this.on('mouseenter', () => {
                    $this.addClass('hovering');
                    speed = .1;
        
                    if (tickerFunction) {
                        gsap.ticker.remove(tickerFunction);
                    }
        
                    tickerFunction = () => {
                        const dt = 1.0 - Math.pow(1 - speed, gsap.ticker.deltaRatio());
                        pos.x += (mouse.x - pos.x) * dt;
                        pos.y += (mouse.y - pos.y) * dt;
        
                        xSet(pos.x);
                        ySet(pos.y);
                    };
        
                    gsap.ticker.add(tickerFunction);
        
                    $('.cursor-text').text(elText);
                    const textWidth = $('.cursor-text').width();
                    $('.ms-cc_p, .ms-cc_p .cursor-view').css('width', `calc(3em + ${textWidth}px)`);
                    $('.ms-cc_p').addClass('active');
                }).on('mouseleave', () => {
                    $this.removeClass('hovering');
                    $('.ms-cc_p').removeClass('active');
                    $('.ms-cc_p .cursor-view').css('width', '100%');
        
                    if (tickerFunction) {
                        gsap.ticker.remove(tickerFunction);
                        tickerFunction = null;
                    }
                });
            });
        }

    }

    // Portfolio List
    function ms_portfolio_list($scope) {

        if (!$.exists('.ms-p--list')) return;
    
        Splitting();

        function animateText($element, rotateValue) {
                    
        // Text Animation          
        Splitting();
            let $container = $element.find('.list__item-root .word'),
            $cloneContainers  = $element.find('.list__item-clone .word');

            gsap.to($container, {
                rotateX: rotateValue,
                duration: 0.3,
                ease: "Quad.easeInOut",
                stagger: 0.065
            });

            gsap.to($cloneContainers, {
                rotateX: rotateValue === 91 ? 0 : -91,
                duration: 0.3,
                ease: "Quad.easeInOut",
                stagger: 0.065
            });

        }
        
        var $cursorArea = $scope.find('.ms-p--list'),
            $hoverElement = $scope.find('.works__category__hover'),
            $parentEl = $scope.find('.works__category__list');

        $scope.on('mouseenter', '.works__category__list__item', function() {
            animateText($(this), 91);
        }).on('mouseleave', '.works__category__list__item', function() {
            animateText($(this), 0);
        });

        let isHovered = false,
            hoverAnimation = null;

        $cursorArea.on('mouseenter', function(e) {
            isHovered = true;

            if (hoverAnimation) {
                hoverAnimation.kill();
            }

            $hoverElement.removeClass('hide');
            
            hoverAnimation = gsap.to($hoverElement,
                { 
                    height: 'auto',
                    duration: 0.4,
                    ease: "Quart.easeOut",
                }
            );
        });
        
        $cursorArea.on('mouseleave', function(e) {
            isHovered = false;

            if (hoverAnimation) {
                hoverAnimation.kill();
            }

             hoverAnimation = gsap.to($hoverElement,
                {
                height: 0,
                duration: 0.5,
                ease: "Quart.easeInOut",
                onComplete: function() {
                    if (!isHovered) {
                        $hoverElement.addClass('hide');
                    }
                }
            });
        });

        function updateHoverEffect() {
            
            let parentOffset = $parentEl.offset();

            $parentEl.on('mouseenter', '.works__category__list__item', function() {
                
                let $child = $(this),
                childCenterY = $child.offset().top + $child.outerHeight() / 2 - parentOffset.top;

                $hoverElement.css({
                    '--y': childCenterY,
                    '--x': $parentEl.outerWidth() / 2,
                    '--index': $child.index()
                });
            });
        }

        updateHoverEffect();

        $(window).on('resize', function() {
            updateHoverEffect();
        });

        const bodyResizeObserver = new ResizeObserver(function(entries) {
            updateHoverEffect();
        });

        bodyResizeObserver.observe(document.body);

    }
    
    // Portfolio Buttons
    function ms_load_more_btn($scope) {

        var pageNum = parseInt(infinity_load.startPage) + 1,
            max = parseInt(infinity_load.maxPages),
            el = $scope.find('.portfolio_wrap'),
            id = el.attr('id'),
            container = el.find('.ms-masonry-gallery'),
            container_g = el.find('.portfolio-feed'),
            contgrid = el.find('.grid-content'),
            wrap_type = el.attr('data-type');

            // Filter
            el.on('click', '.filter-nav__item:not(.active)', function (e) {
                e.preventDefault();

                const filterValue = $(this).data('filter'),
                    url = `${window.location.href}?category=${filterValue}`,
                    button = el.find('.ajax-area'),
                    itemsFeed = el.find('.portfolio-feed'),
                    preloader = el.find('.load_filter').addClass('show'),
                    $pItem = container.find('.grid-item-p');

                pageNum = parseInt(infinity_load.startPage) + 1;

                // Disable pointer events and set initial opacity
                el.find('.grid-item-p').css('pointer-events', 'none');
                gsap.to(el.find('.grid-item-p'), { opacity: 0.4, duration: 0.3 });

                // Remove button with animation
                if (button.length) {
                    gsap.to(button.get(0), {
                        opacity: 0,
                        duration: 0.15,
                        onComplete: () => {
                            gsap.to(button.get(0), {
                                height: 0,
                                duration: 0.3,
                                onComplete: () => button.remove(),
                                clearProps: 'height',
                            });
                        },
                    });
                }

                // Update filter state
                el.find('.filter-nav__item').removeClass('active');
                $(this).addClass('active');
                el.find('.filtr-btn li .subnav__link').attr('aria-current', 'none');
                $(this).find('.subnav__link').attr('aria-current', 'page');
                el.find('.filtr-btn li').css('pointer-events', 'none');
                $pItem.css('pointer-events', 'none');

                // Ajax request to load filtered content
                $.ajax({
                    type: 'GET',
                    url: url,
                    dataType: 'html',
                    success: function (data) {
                        const $data = $(data),
                            items = $data.find(`#${id} .grid-item-p`),
                            newButton = $data.find(`#${id} .ajax-area`);

                        // Handle grid layout (masonry or simple grid)
                        if (wrap_type !== 'list') {
                            handleGridLayout(items, newButton, itemsFeed);
                        } else {
                            handleListLayout($data, newButton);
                        }
                    },
                });

                function handleGridLayout(items, newButton, itemsFeed) {
                    const originalHeight = itemsFeed.outerHeight();

                    container.imagesLoaded(() => {
                        
                        if ($.exists(contgrid)) {
                            container.imagesLoaded( function() {
                                container.isotope({
                                    itemSelector: '.grid-item-p',
                                    percentPosition: true,
                                    masonry: {
                                        columnWidth: '.grid-sizer'
                                    }
                                });
                            });
                            if(items.length > 0) {
                                container.append(items).isotope( 'appended', items );
                            }
                            container.isotope('reloadItems').isotope('remove', $pItem);
                            el.append(newButton);
                            el.find('.load_filter').removeClass('show');
                            el.find('.filtr-btn li').css('pointer-events', 'auto');
                        } else {
                            container_g.imagesLoaded(() => {
                                animateItemRemoval(itemsFeed, originalHeight, items, newButton);
                            });
                        }

                        ms_custom_cursor_portfolio(items);
                        ms_video_thumb(items);
                        
                    });
                }

                function animateItemRemoval(itemsFeed, originalHeight, items, newButton) {
                    gsap.fromTo(container_g.find('.grid-item-p'), {
                        clipPath: "polygon(100% 0, 0 0, 0 100%, 100% 100%)"
                    }, {
                        clipPath: "polygon(100% 0, 0 0, 0 0%, 100% 0%)",
                        duration: 0.4,
                        ease: "power3.inOut",
                        stagger: 0.06,
                        onComplete: () => {
                            container_g.find('.grid-item-p').css('--aspect', '0').remove();
                            container_g.append(items);
                            if ( container_g.hasClass('ms-p--g2') ){
                                items.removeClass('f_l');
                                items.addClass('f_a');
                            }
                            animateContainerResize(itemsFeed.outerHeight(), items, newButton);
                        }
                    });
                }

                function animateContainerResize(originalHeight, items, newButton) {
                    const newHeight = container_g.outerHeight();

                    gsap.fromTo(container_g, { height: originalHeight }, {
                        height: newHeight,
                        duration: 0.3,
                        clearProps: "height"
                    });

                    if (newButton.length) {
                        el.append(newButton);
                        animateButtonAppearance(newButton);
                    }

                    gsap.fromTo(items, {
                        clipPath: "polygon(100% 0, 0 0, 0 0%, 100% 0%)",
                        opacity: .4
                    }, {
                        clipPath: "polygon(100% 0, 0 0, 0 100%, 100% 100%)",
                        duration: 0.5,
                        ease: "power3.inOut",
                        stagger: 0.06,
                        delay: 0.1,
                        onComplete: () => {
                            preloader.removeClass('show'); // Первое действие
                            gsap.to(items, { opacity: 1, duration: 0.5 }); // Второе действие
                            el.find('.filtr-btn li').css('pointer-events', 'auto');
                        }
                    });
                    locoScroll.addScrollElements(document.documentElement);
                }

                function animateButtonAppearance(newButton) {
                    const buttonHeight = newButton.height();
                    gsap.set(newButton, { height: 0, opacity: 0.4 });
                    gsap.to(newButton, {
                        height: buttonHeight,
                        duration: 0.3,
                        onComplete: () => gsap.to(newButton, { opacity: 1 })
                    });
                }

                function handleListLayout($data, newButton) {
                    const valList = $data.find(`#${id} .works__category__list__item`),
                        valListThumb = $data.find(`#${id} .works__category__list__image`);

                    el.find('.works__category__list').html(valList);
                    el.find('.works__category__hover__content').html(valListThumb);
                    el.append(newButton);
                    el.find('.load_filter').removeClass('show');
                    el.find('.filtr-btn li').css('pointer-events', 'auto');
                }
                
            });

            // Load Button
            el.on('click', '.btn-load-more', function(event){

                var nextLink = infinity_load.nextLink;
                nextLink = nextLink.replace(/\/page\/[0-9]?/,'/page/'+ pageNum);

                event.preventDefault();
                var posts_container = el.find('.ms-masonry-gallery'),
                    button = $(this),
                    filterValue =  el.find('.filtr-btn li.active').attr('data-filter'),
                    itemsFeed = el.find('.portfolio-feed');
                if (filterValue === undefined || filterValue === '') {
                    filterValue = '';
                }
                
                $(this).toggleClass('loading');
                el.find('.grid-item-p').css({'pointer-events' : 'none'});
                $('.md-content-loader').addClass('active');
                var max = el.find('.ajax-area').attr('data-max');
                   
                    button.css({'pointer-events' : 'none'});
                    
                    pageNum++;
                    
                        $.ajax({
                            type: 'POST',
                            url: nextLink + '?category=' + filterValue,
                            dataType: 'html',
                            success: function(data) {

                                const item = $(data),
                                    all_cat_count = el.find('ul.filtr-btn li:first').find('span').text();

                                nextLink = nextLink.replace(/\/page\/[0-9]?/,'/page/'+ pageNum);

                                if ( wrap_type !== 'list' ) {

                                    const val = item.find(`#${id} .grid-item-p`);
                                    const total_cat_count = parseInt(all_cat_count, 10) + val.length;
                                    const $container = $.exists(contgrid) 
                                        ? el.find('.ms-masonry-gallery').isotope() 
                                        : el.find('.portfolio-feed');

                                    if(val.length > 0) {
                                        
                                        setTimeout(function() {

                                            button.find('.ajax-area');
                                            toggleLoading(button, false);

                                            var originalHeight = itemsFeed.outerHeight(); 

                                            $container.imagesLoaded(function() {
                                                if ($.exists(contgrid)) {
                                                    $container.append(val).isotope('appended', val);
                                                } else {
                                                    $container.append(val);
                                                            if ( container_g.hasClass('ms-p--g2') ){
                                                                val.removeClass('f_l');
                                                                val.addClass('f_b');
                                                            }
                                                    const newHeight = container_g.outerHeight();

                                                    gsap.fromTo(container_g, { height: originalHeight }, {
                                                        height: newHeight,
                                                        duration: 0.3,
                                                        clearProps: "height"
                                                    });
                                                    gsap.fromTo(val, {
                                                        clipPath: "polygon(100% 0, 0 0, 0 0%, 100% 0%)",
                                                        opacity: .1
                                                    }, {
                                                        clipPath: "polygon(100% 0, 0 0, 0 100%, 100% 100%)",
                                                        duration: 0.6,
                                                        ease: "power3.inOut",
                                                        stagger: 0.06,
                                                        opacity: 1,
                                                        delay: 0.1,
                                                    });

                                                }
                                            });
                                        
                                            updateCategoryCount(el, total_cat_count);
 
                                            if (pageNum > max) {
                                                disableButton(button);
                                            }

                                            refreshLocomotiveScroll();

                                            $scope = val;
                                            enableGridItems(el);
                                            ms_custom_cursor_portfolio($scope);
                                            ms_video_thumb($scope);

                                        }, 1500);
                                        
                                    }
                                // List
                                } else {
                                    const val_list = item.find(`#${id} .works__category__list__item`);
                                    const total_cat_count = parseInt(all_cat_count, 10) + val_list.length;
                                    const val_list_thumb = item.find(`#${id} .works__category__list__image`);
                                    const $container = el.find('.works__category__list');
                                    const $container_thumb = el.find('.works__category__hover__content');

                                    button.find('.ajax-area');
                                    toggleLoading(button, false);

                                    $container.append(val_list);
                                    $container_thumb.append(val_list_thumb);

                                    updateCategoryCount(el, total_cat_count);
 
                                    if (pageNum > max) {
                                        disableButton(button);
                                    }

                                    refreshLocomotiveScroll();

                                    function initializeSplitting($newElements) {
                                        $newElements.each(function() {
                                            Splitting({ target: $(this).find('[data-splitting]')[0] });
                                        });
                                    }

                                    $(document).on('ajaxComplete', function(e, xhr, settings) {
                                        let $newItems = $(val_list).find('.works__category__list__item');
                                        Splitting();
                                        initializeSplitting($newItems);
                                        
                                        $newItems.each(function() {
                                            animateText($(this), 0);
                                        });
                                    });

                                }
                                
                                // Functions
                                function toggleLoading(button, isLoading) {
                                    button.toggleClass('loading', isLoading);
                                    button.css({'pointer-events': isLoading ? 'none' : 'auto'});
                                }
                                function updateCategoryCount(el, count) {
                                    el.find('ul.filtr-btn li:first').find('span').text(count);
                                }
                                function disableButton(button) {
                                    button.addClass('no-works');
                                    button.css({'pointer-events': 'none'});
                                }
                                function refreshLocomotiveScroll() {
                                    setTimeout(function() {
                                        locoScroll.addScrollElements(document.documentElement);
                                    }, 10);
                                }
                                function enableGridItems(el) {
                                    el.find('.grid-item-p').css({'pointer-events': 'auto'});
                                }
                            }
                        });

            });

    }
    
    // Accordion Widget
    function ms_accordion_widget($scope) {

        let el = $scope.find('.ms_accordion');
        let el_panel = el.find('.ms_ac_panel');
        let el_label = el_panel.find('.ms_ac--label');

        let groups = gsap.utils.toArray(el_panel);
        let menus = gsap.utils.toArray(el_label);
        let menuToggles = groups.map(createAnimation);

        menus.forEach((menu) => {
            menu.addEventListener("click", () => toggleMenu(menu));
        });

        function toggleMenu(clickedMenu) {
            menuToggles.forEach((toggleFn) => toggleFn(clickedMenu));
        }

        function createAnimation(element) {

            let menu = element.querySelector('.ms_ac--label');
            let box = element.querySelector('.ms_ac--content');
            let minusElement = element.querySelector('.accordion_icon--close');
            let plusElement = element.querySelector('.accordion_icon--open');

            gsap.set(box, { height: "auto" });
            
            if ($.exists('.switching')) {
                var animation = gsap
                .timeline().from(box, {
                    height: 0,
                    duration: 0.5,
                    ease: "power2.inOut"
                })
                .from(minusElement, { duration: 0.2, autoAlpha: 0, ease:"none" }, 0)
                .to(plusElement, { duration: 0.2, autoAlpha: 0, ease:"none" }, 0)
                .reverse();
            } else {
                var animation = gsap
                .timeline().from(box, {
                    height: 0,
                    duration: 0.5,
                    ease: "power2.inOut"
                })
                .to(plusElement, { duration: 0.2, rotation:"180_cw", ease:"none" }, 0)
                .reverse();
            }

            if (el.data('collapse')) {
                return function (clickedMenu) {
                    if (clickedMenu === menu) {
                        animation.reversed(!animation.reversed());
                    } else {
                        animation.reverse();
                    }
                };
            } else {
                return function (clickedMenu) {
                    if (clickedMenu === menu) {
                        animation.reversed(!animation.reversed());
                    }
                };
            }

        }

    }
    
    // Isotope
    function ms_isotope_card_grid($scope) { 
    
        var grid = $scope.find('.grid-content');
        // init Isotope
        grid.imagesLoaded(function () { grid.isotope(); });
        
    }
    
    // Masonry Gallery
    function ms_masonry_gallery($scope) {
     
        var grid = $scope.find('.ms-masonry-gallery');
    
        grid.imagesLoaded(function () { grid.isotope(); });
    
        var el_2 = $scope.find('.blockgallery.h_s2').find('.mfp-img img');

        $(el_2).on('mouseenter', function () {
            $(el_2).css('opacity', '0.5');
        });

        $(el_2).on('mouseleave', function () {
            $(el_2).css('opacity', '1');
        });
    
    }

    // Parallax Hero
    function ms_parallax_hero($scope) {

        var el = $scope.find('.ms-parallax'),
            video = el.find('.jarallax-img').attr('data-video-src'),
            video_start = el.find('.jarallax-img').attr('data-video-start-time'),
            video_end = el.find('.jarallax-img').attr('data-video-end-time');
        
        el.jarallax({ 
            videoSrc: video,
            loop: true,
            videoStartTime: video_start,
            videoEndTime: video_end,
        });

    }

    // Swiper Slider Options
    function ms_slider($scope) {

        var slider_global = $scope.find('.ms-slider');

        var checkCLass = slider_global;
        Splitting();
        // Swiper Material
        if (checkCLass.hasClass('material-slider')) {

            // Swiper Meterial
            var el_material = $scope.find('.swiper.ms-slider-material'),
                effect = el_material.attr('data-effect'),
                nav_next = el_material.find('.swiper-button-next'),
                nav_prev = el_material.find('.swiper-button-prev'),
                scrollbar = el_material.find('.swiper-scrollbar'),
                centered = ( 'on' === el_material.attr('data-centered') ) ? true : false,
                autoplay = ( 'on' === el_material.attr('data-autoplay') ) ? true : false,
                wheel = ( 'on' === el_material.attr('data-mousewheel') ) ? true : false,
                st = ( 'on' === el_material.attr('data-simulatetouch') ) ? true : false,
                loop = ( 'on' === el_material.attr('data-loop') ) ? true : false,
                delay = el_material.attr('data-delay'),
                slides = el_material.attr('data-spv'),
                slides_t = el_material.attr('data-spv-t'),
                slides_m = el_material.attr('data-spv-m'),
                space = el_material.attr('data-space'),
                space_t = el_material.attr('data-space-t'),
                space_m = el_material.attr('data-space-m'),
                speed = el_material.attr('data-speed'),
                anim_class = el_material.find('.ms-slider--cont'),
                swiper = new Swiper(el_material.get(0), {
                modules: [EffectMaterial],
                effect: effect,
                slidesPerView:  eval(slides),
                centeredSlides: centered,
                spaceBetween: eval(space),
                speed: speed,
                autoplay: autoplay,
                mousewheel: wheel,
                loop: loop,
                simulateTouch: st,
                navigation: {
                    nextEl: nav_next.get(0),
                    prevEl: nav_prev.get(0),
                },
                scrollbar: {
                    el: scrollbar.get(0),
                    hide: false,
                    draggable: true,
                },
                on: {
                    init: function () {
                        var activeIndexTitle = $(this.slides[this.activeIndex]).find('.ms-sc--t');
                        var first_slide_char = activeIndexTitle.find('.char');
                        slideFirstInit(first_slide_char);
                    },
                },
                breakpoints: {
                    '@0.25': {
                        slidesPerView: 1,
                        spaceBetween: eval(space_m)
                    },
                    768: {
                        slidesPerView: slides_t,
                        spaceBetween: eval(space_t)
                    },
                    1024: {
                        slidesPerView: eval(slides),
                        spaceBetween: eval(space)
                    }
                },
            });

            if (anim_class.hasClass('swiper-material-animate-scale')) {
                
                swiper.on('slideChangeTransitionEnd', function () {
                    var activeSlideIndex = this.activeIndex;
                    var el_char_end = $(this.slides[activeSlideIndex]).find('.ms-sc--t');
                    slideTitlesEnd(el_char_end);
                });
    
                swiper.on('slideChangeTransitionStart', function () {
                    var el_char_start = $scope.find('.ms-sc--t');
                    slideTitlesStart(el_char_start);
                });
            }

            swiper.params.autoplay.delay = delay;
        }

        // Swiper Triple
        if (checkCLass.hasClass('triple-slider')) {

            const el_triple = $scope.find('.triple-slider');
            var el_attr = el_triple.find('.ms-slider-triple'),
                wheel = ( 'on' === el_attr.attr('data-mousewheel') ) ? true : false,
                st = ( 'on' === el_attr.attr('data-simulatetouch') ) ? true : false,
                speed = el_attr.attr('data-speed');
            const sliderEl = el_triple.get(0);
            createTripleSlider(sliderEl);
            
            function createTripleSlider(el) {
                const swiperEl = el.querySelector('.swiper');
                const swiperPrevEl = swiperEl.cloneNode(true);
                swiperPrevEl.classList.add('triple-slider-prev');
                el.insertBefore(swiperPrevEl, swiperEl);
                const swiperPrevSlides = swiperPrevEl.querySelectorAll('.swiper-slide');
                const swiperPrevLastSlideEl = swiperPrevSlides[swiperPrevSlides.length - 1];
                swiperPrevEl
                .querySelector('.swiper-wrapper')
                .insertBefore(swiperPrevLastSlideEl, swiperPrevSlides[0]);

                const swiperNextEl = swiperEl.cloneNode(true);
                swiperNextEl.classList.add('triple-slider-next');
                el.appendChild(swiperNextEl);
                const swiperNextSlides = swiperNextEl.querySelectorAll('.swiper-slide');
                const swiperNextFirstSlideEl = swiperNextSlides[0];
                swiperNextEl
                .querySelector('.swiper-wrapper')
                .appendChild(swiperNextFirstSlideEl);
            
                swiperEl.classList.add('triple-slider-main');

                const commonParams = {
                
                speed: speed,
                loop: true,
                parallax: true,
                mousewheel: wheel,
                autoplay: autoplay,
                simulateTouch: st

                };
            
                let tripleMainSwiper;
            
                // init prev swiper
                const triplePrevSwiper = new Swiper(swiperPrevEl, {
                ...commonParams,
                allowTouchMove: false,
                mousewheel: false,
                on: {
                    click() {
                    tripleMainSwiper.slidePrev();
                    },
                    init() {
                        $('.ms-sc--t').css({
                            'opacity': '1',
                        });
                        gsap.to( '.ms-sc--t, .bg-image', { 
                            opacity: 1,
                            duration: .7,
                            ease: 'ease-in-out',
                        });
                    }
                },
                });
                
                // init next swiper
                const tripleNextSwiper = new Swiper(swiperNextEl, {
                ...commonParams,
                allowTouchMove: false,
                mousewheel: false,
                on: {
                    click() {
                    tripleMainSwiper.slideNext();
                    },
                },
                });
                // init main swiper
                tripleMainSwiper = new Swiper(swiperEl, {
                ...commonParams,
                grabCursor: true,
                controller: {
                    control: [triplePrevSwiper, tripleNextSwiper],
                },
                on: {
                    destroy() {
                    // destroy side swipers on main swiper destroy
                    triplePrevSwiper.destroy();
                    tripleNextSwiper.destroy();
                    },
                },
                });

                return tripleMainSwiper;
            }
        }

        // Swiper Default
        if (checkCLass.hasClass('default-slider')) {
            
            var el_default = $scope.find('.swiper.ms-slider-default'),
                nav_prev = el_default.find('.ms-nav--prev'),
                nav_next = el_default.find('.ms-nav--next'),
                nav_pagination = el_default.find('.ms-wrap-nav .swiper-pagination'),
                scrollbar = el_default.find('.swiper-scrollbar'),
                effect = el_default.attr('data-effect'),
                direction = el_default.attr('data-direction'),
                slides = el_default.attr('data-spv'),
                slides_t = el_default.attr('data-spv-t'),
                slides_m = el_default.attr('data-spv-m'),
                speed = el_default.attr('data-speed'),
                space = el_default.attr('data-space'),
                space_t = el_default.attr('data-space-t'),
                space_m = el_default.attr('data-space-m'),
                delay = el_default.attr('data-autoplay-delay'),
                anim_class = el_default.find('.ms-slider--cont'),
                scrollbar_hide = el_default.find('.swiper-scrollbar'),
                scrollbar_draggable = el_default.find('.swiper-scrollbar'),
                loop = ( 'on' === el_default.attr('data-loop') ) ? true : false,
                autoplay = ( 'enable' === el_default.attr('data-autoplay') ) ? true : false,
                centered = ( 'on' === el_default.attr('data-centered') ) ? true : false,
                wheel = ( 'on' === el_default.attr('data-mousewheel') ) ? true : false,
                side = ( 'ltr' === el_default.attr('data-side') ) ? true : false,
                st = ( 'on' === el_default.attr('data-simulatetouch') ) ? true : false,
                pbo = ( 'vertical' === el_default.attr('data-direction') ) ? true : false,
                scrollbar_h = ( 'on' === scrollbar_hide.attr('data-interaction') ) ? true : false,
                scrollbar_d = ( 'on' === scrollbar_draggable.attr('data-dragable') ) ? true : false;
                
                if ( slides === '0' ) {
                    slides = 'auto';
                }
                if (!direction) {
                    direction = 'horizontal';
                }

                var swiper = new Swiper(el_default.get(0), {
                    effect: effect,
                    slidesPerView: slides,
                    direction: direction,
                    spaceBetween: eval(space),
                    loop: loop,
                    autoplay: {
                        delay: delay,
                        reverseDirection: side,
                        disableOnInteraction: true,
                    },
                    centeredSlides: centered,
                    speed: eval(speed),
                    mousewheel: wheel,
                    simulateTouch: st,
                    scrollbar: {
                        el: scrollbar.get(0),
                        hide: scrollbar_h,
                        draggable: scrollbar_d,
                    },
                    navigation: {
                        nextEl: nav_next.get(0),
                        prevEl: nav_prev.get(0),
                    },
                    pagination: {
                        el: nav_pagination.get(0),
                        clickable: true,
                      },
                    breakpoints: {
                        '@0.25': {
                            slidesPerView: slides_m,
                            spaceBetween: eval(space_m)
                        },
                        768: {
                            slidesPerView: slides_t,
                            spaceBetween: eval(space_t)
                        },
                        1024: {
                            slidesPerView: slides,
                            spaceBetween: eval(space)
                        }
                    },
                    on: {
                        init: function () {
                            var activeIndexTitle = $(this.slides[this.activeIndex]).find('.ms-sc--t');
                            var first_slide_char = activeIndexTitle.find('.char');
                            slideFirstInit(first_slide_char);
                        },
                        resize: function () {
                            if ( autoplay !== false ) {
                                setTimeout(() => {
                                    this.updateSize();
                                    this.update();
                                    this.setTranslate(0);
                                    if (this.autoplay) {
                                        this.autoplay.stop();
                                        this.autoplay.start();
                                    }
                                }, 100);
                            }
 
                        },
                    },
                });

            if ( autoplay === false) {
                swiper.autoplay.stop();
            }
            
            swiper.params.autoplay.delay = delay;
            swiper.update();
            
            if (anim_class.hasClass('swiper-material-animate-scale')) {
            swiper.on('slideChangeTransitionEnd', function () {
                var activeSlideIndex = this.activeIndex;
                var el_char_end = $(this.slides[activeSlideIndex]).find('.ms-sc--t');
                slideTitlesEnd(el_char_end);
            });

            swiper.on('slideChangeTransitionStart', function () {
                var el_char_start = $scope.find('.ms-sc--t');
                slideTitlesStart(el_char_start);
                updateParentHeight();
            });
            }
        }

        // Swiper Osty
        if (checkCLass.hasClass('osty-slider')) {
            gsap.config({
                nullTargetWarn: false
            });
            var el_osty = $scope.find('.swiper.ms-slider-osty');
            var el_osty_thumb = $scope.find('.thumbs-slider');
            const titles_wrap = $scope.find('.ms-f-s--info_title');
            const titles = titles_wrap.find('.ms-sc--t').toArray();
            // const titles_h = titles_wrap.find('.ms-sc--t').outerHeight();
            const desc_wrap_info = $scope.find('.ms-f-s--info_desc');
            const desc_wrap_role = $scope.find('.ms-f-s--desc-rs');
            const desc_wrap_services = $scope.find('.ms-f-s--desc-sc');
            const desc_wraps = [desc_wrap_info, desc_wrap_role, desc_wrap_services];
            // titles_wrap.css('height', titles_h);
            
            desc_wraps.forEach((wrap) => {
                const firstDesc = wrap.find('.ms-sc--d').first().find('.word .char');
                const firstDesc_W = wrap.find('.ms-sc--d').first().find('.words');
                const descLabelHeight = wrap.find('.ms-sc-label').outerHeight();
                const firstDescHeight = firstDesc_W.outerHeight();
                const descWrapHeight = firstDescHeight + descLabelHeight;
                wrap.css('height', descWrapHeight + 'px');
                gsap.set(firstDesc, { y: 0, opacity: 1 });

            });
            
            // Image slider
            if (el_osty.length > 0) {
                
                var thumbsSwiper = new Swiper(el_osty_thumb.get(0), {
                    watchSlidesProgress: true,
                });
            
                var swiper = new Swiper(el_osty.get(0), {

                    effect: "creative",
                    creativeEffect: {
                      prev: {
                        shadow: false,
                        translate: [0, 0, -500],
                      },
                      next: {
                        translate: [0, "100%", 0],
                      },
                    },

                    slidesPerView: 1,
                    direction: 'vertical',
                    preventInteractionOnTransition: true,
                    spaceBetween: 10,
                    loop: true,
                    autoplay: false,
                    speed: 1100,
                    mousewheel: true,
                    thumbs: {
                        swiper: thumbsSwiper,
                    },
                    on: {
                        init: function () {
                            setTimeout(() => {
                                if (this.slides && this.slides.length > 0) {
                                    updateLink(this.realIndex);
                                    updateSlideNumber(this.realIndex, 0);
                                    let realIndex = this.realIndex || 0;
                                    gsap.set(titles[realIndex], { rotateX: 0, opacity: 1 });
                                }
                            }, 100);                        
                        },
                        slideChangeTransitionStart: function () {

                            if (this.slides && this.slides.length > 0) {
                                let currentSlideIndex = this.realIndex;
                                let previousSlideIndex = this.previousRealIndex;
            
                                let slidesCount = this.slides.length - 1;
                                let direction = (currentSlideIndex > previousSlideIndex) || 
                                (previousSlideIndex === slidesCount && currentSlideIndex === 0)
                                ? 'next'
                                : (previousSlideIndex === 0 && currentSlideIndex === slidesCount)
                                ? 'prev'
                                : 'prev';
                                
                                if (currentSlideIndex !== slidesCount) {
                                    if (currentSlideIndex > previousSlideIndex) {
                                        direction = 'next';
                                    }
                                } else if (previousSlideIndex !== 0) {
                                    direction = 'next';
                                } else {
                                    direction = 'prev';
                                }

                                updateLink(currentSlideIndex);
            
                                animateTitles(previousSlideIndex, currentSlideIndex, direction);
                                animateText(previousSlideIndex, currentSlideIndex, direction, 'ms-f-s--info_desc');

                                // animateText(previousSlideIndex, currentSlideIndex, direction, 'ms-f-s--desc-rs');
                                // animateText(previousSlideIndex, currentSlideIndex, direction, 'ms-f-s--desc-sc');
                                // UPD
                                ['ms-f-s--desc-rs','ms-f-s--desc-sc'].forEach(mainClass => {
                                    if ($scope.find(`.${mainClass} .ms-sc--d`).length) {
                                        animateText(previousSlideIndex, currentSlideIndex, direction, mainClass);
                                    }
                                });
                                updateSlideNumber(currentSlideIndex, previousSlideIndex, direction);
                                this.previousRealIndex = currentSlideIndex;
                            }
                        },

                    }
                });

            }

            function handleScrollEvent() {
                if ($(window).width() > 1400) {
                    $scope.on('wheel', function(e) {
                        e.preventDefault();
                        if (e.originalEvent.deltaY > 0) {
                            swiper.slideNext();
                        } else {
                            swiper.slidePrev();
                        }
                    });
                } else {
                    $scope.off('wheel');
                }
            }

            function updateLink() {
                if ($(window).width() <= 1400) {
                    let activeSlide = el_osty.find('.swiper-slide-active');
                    let slideLinkElement = activeSlide.find('a.ms-f-s-link');
                    let targetLinkElement = $('.ns-link .ms-f-s-link');

                    if (slideLinkElement.length > 0) {
                        let slideLink = slideLinkElement.attr('href');
                        let slideLinkText = slideLinkElement.attr('data-text');
                        
                        targetLinkElement.animate({ opacity: 0 }, 300, function () {
                            targetLinkElement.attr('href', slideLink);
                            targetLinkElement.text(slideLinkText);
                            targetLinkElement.removeClass('disable');
                            targetLinkElement.animate({ opacity: 1 }, 600);
                        });
                    } else {
                        targetLinkElement.attr('href', '#');
                        targetLinkElement.addClass('disable');
                    }
                } else {
                    $('.ns-link .ms-f-s-link').attr('href', '#').addClass('disable');
                }
            }

            handleScrollEvent();
            updateLink();

            $(window).on('resize', function() {
                handleScrollEvent();
                updateLink();
            });

            swiper.on('slideChangeTransitionStart', function() {
                updateLink();
            });
            
            // Title Animation
            function animateTitles(previousIndex, currentIndex, direction) {
                let currentTitles = titles[currentIndex];
                let previousTitles = titles[previousIndex];
            
                gsap.set(currentTitles, { rotateX: direction === 'next' ? -90 : 90, opacity: 0 });
            
                gsap.timeline()
                    .to(previousTitles, {
                        rotateX: direction === 'next' ? 90 : -90,
                        opacity: 0,
                        duration: 1,
                        ease: "Quad.easeInOut",
                        onComplete: function () {
                            gsap.set(previousTitles, { rotateX: -90, opacity: 0 });
                        }
                    })
                    .to(currentTitles, {
                        rotateX: 0,
                        opacity: 1,
                        duration: 1,
                        ease: "Quad.easeInOut"
                    }, "-=1");
            }

            // Text Animation
            function animateText(previousIndex, currentIndex, direction, mainClass) {
                let desc_wrap = $(`.${mainClass}`);
                let desc_info = desc_wrap.find('.ms-sc--d');
                let desc_label_h = desc_wrap.find('.ms-sc-label').outerHeight();
                
                if (!desc_info[currentIndex] || !desc_info[previousIndex]) {
                    console.error(`Elements not found for the provided index. currentIndex: ${currentIndex}, previousIndex: ${previousIndex}`);
                    return;
                }
            
                let currentWords = $(desc_info[currentIndex]).find('.word .char');
                let currentWords_h = $(desc_info[currentIndex]).find('.words');
                let previousWords = $(desc_info[previousIndex]).find('.word .char');

                gsap.set(currentWords, { 
                    y: direction === 'next' ? 50 : -50, opacity: 0
                });
            
                gsap.timeline()
                    .to(previousWords, {
                        y: direction === 'next' ? -50 : 50,
                        opacity: 0,
                        duration: 1,
                        ease: "Quad.easeInOut",
                        onComplete: function () {
                            gsap.set(previousWords, { y: 0, opacity: 0 });
                        }
                    })
                    .to(currentWords, {
                        y: 0,
                        opacity: 1,
                        duration: 1,
                        ease: "Quad.easeInOut",
                        onStart: () => updateTextHeight(currentWords_h)
                    }, "-=.95");
            
                function updateTextHeight(word) {
                    const newHeight = $(word).outerHeight() + desc_label_h;
                    gsap.to(desc_wrap, {
                        height: newHeight + 'px',
                        duration: 1,
                        ease: "Quad.easeInOut"
                    });
                }
            }

            // Number Animation
            function updateSlideNumber(currentIndex, previousIndex, direction) {
                var currentSlideElement = $scope.find('.ns-current .ns-number').eq(currentIndex);
                var previousSlideElement = $scope.find('.ns-current .ns-number').eq(previousIndex);

                let number_h = $scope.find('.ns-zero').outerHeight();
                let number_w = currentSlideElement.outerWidth();

                $scope.find('.ns-current-number').css({
                    'height': number_h + 'px',
                    'width': number_w + 'px'
                });
            
                gsap.set(currentSlideElement, {
                    y: direction === 'next' ? 50 : -50,
                    opacity: 0
                });

                gsap.timeline()
                    .to(previousSlideElement, {
                        y: direction === 'next' ? -50 : 50,
                        opacity: 0,
                        duration: 1,
                        ease: "Quad.easeInOut",
                        onComplete: function () {
                            gsap.set(previousSlideElement, { y: 0, opacity: 0 });
                        }
                    })
                    .to(currentSlideElement, {
                        y: 0,
                        opacity: 1,
                        duration: 1,
                        ease: "Quad.easeInOut",
                    }, "-=.95");
            }

        }

        // Content Text Effect
        function slideFirstInit(first_slide_char) {
            var first_slide_load = $scope.find('.char'),
                first_slide_img = $scope.find('.swiper-slide img, .bg-image');
            first_slide_load.css({
                'opacity': '0',
                'transform': 'scale(0,0)'
            });

            setTimeout(function () {
                $('.ms-sc--t').css({
                    'opacity': '1',
                });
                gsap.to( first_slide_img, { 
                    opacity: 1,
                    duration: .7,
                    ease: 'ease-in-out',
                });
            }, 700);

            setTimeout(function () {

                const words = $scope.find('.word');
                for (const word of words) {
                    const tl = gsap.timeline();
                    const chars = first_slide_char;
        
                    const wordTimeline = gsap.timeline().fromTo(chars, { 
                        willChange: 'transform, opacity',
                        opacity: 0,
                        scale: 1.7
                    },
                    {
                        duration: .7,
                        ease: 'power2',
                        opacity: 1,
                        scale: 1,
                        stagger: {
                            each: 0.015,
                            from: 'edges'
                        },
                        onComplete: function() {
                            swiper.allowSlideNext = true;
                            swiper.allowSlidePrev = true;
                        }
                    });
                    // tl.add(wordTimeline, Math.random()*.5);
                }

            }, 1000);
        }

        function slideTitlesEnd(slideIndex) {

            var slideTitles = slideIndex;
            const tl = gsap.timeline();
            
            if ( slideTitles.length ) {
                swiper.allowSlideNext = false;
                swiper.allowSlidePrev = false;
            }

            const words = slideTitles.find('.word');

            for (const word of words) {

                const chars = word.querySelectorAll('.char');
    
                const wordTimeline = gsap.timeline().fromTo(chars, { 
                    willChange: 'transform, opacity',
                    opacity: 0,
                    scale: 1.7
                },
                {
                    duration: .7,
                    ease: 'power2',
                    opacity: 1,
                    scale: 1,
                    stagger: {
                        each: 0.015,
                        from: 'edges'
                    },
                    onComplete: function() {
                        swiper.allowSlideNext = true;
                        swiper.allowSlidePrev = true;
                    }
                });
                tl.add(wordTimeline, Math.random()*.5);
            }

        }

        function slideTitlesStart(el_char) {

            const slideTitles = el_char;
            const tl = gsap.timeline();
            const words = slideTitles.find('.word');

            for (const word of words) {

                const chars = word.querySelectorAll('.char');
    
                const wordTimeline = gsap.timeline().fromTo(chars, {
                    willChange: 'transform, opacity',
                    scale: 1
                },
                {
                    duration: .25,
                    ease: 'power1.in',
                    opacity: 0,
                    scale: 0,
                    stagger: {
                        each: 0.02,
                        from: 'edges'
                    },
                });
                tl.add(wordTimeline, Math.random()*.5);
            }

        }

    }

    // Video Button
    function ms_video_button($scope) {
    
        var el = $scope.find('.ms-vb').find('.ms-vb--src'),
            autoplay = el.attr('data-autoplay'),
            type = el.attr('data-video'),
            loop = el.attr('data-loop'),
            controls = el.attr('data-controls'),
            muted = el.attr('data-muted');
        if ( type === 'youtube' ) {
            var start = el.attr('data-start'),
                end = el.attr('data-end');
        } else {

        }

        el.magnificPopup({
            type: 'iframe',
            iframe: {
                patterns: {
                    youtube: {
                        index: 'youtube.com/', 
                        id: function(url) {        
                            var m = url.match(/[\\?\\&]v=([^\\?\\&]+)/);
                            if ( !m || !m[1] ) return null;
                            return m[1];
                        },
                        src: 'https://www.youtube.com/embed/%id%?autoplay='+autoplay+'&loop='+loop+'&controls='+controls+'&mute='+muted+'&start='+start+'&end='+end
                    },
                    vimeo: {
                        index: 'vimeo.com/', 
                        id: function(url) {        
                            var m = url.match(/(https?:\/\/)?(www.)?(player.)?vimeo.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/);
                            if ( !m || !m[5] ) return null;
                            return m[5];
                        },
                        src: '//player.vimeo.com/video/%id%?autoplay=' + autoplay + '&loop=' + loop + '&controls=' + controls + '&muted=' +  muted
                    }
                },
                markup: '<div class="mfp-iframe-scaler">'+
                    '<div class="mfp-close"></div>'+
                    '<iframe class="mfp-iframe" frameborder="0" allowfullscreen allow="autoplay *; fullscreen *"></iframe>'+
                    '<div class="mfp-title">Some caption</div>'+
                    '</div>'
            },
            callbacks: {
                markupParse: function(template, values, item) {
                    values.title = item.el.attr('data-caption');
                }
            },
        });
    
    }
    
    // Justified Gallery
    function ms_lightbox($scope) {
    
        var el = $scope.find('.blockgallery'),
            justified = $scope.find('.justified-gallery'),
            m = justified.data('margins'),
            h = justified.data('row-height');
    
            justified.justifiedGallery({
                rowHeight : h,
                margins : m,
                captions : false,
                border: 0,
                lastRow : 'nojustify',
            });

            el.magnificPopup({
                delegate: '.mfp-img',
                mainClass: 'mfp-fade',
                tClose: 'Fechar (Esc)',
                tLoading: '',
                type: 'image',
                image: {
                   titleSrc: function(item) {
                      return item.el.attr("title");;
                   }
                },
                gallery: {
                    enabled:true,
                    preload: [0,2],
                },
    
                mainClass: 'mfp-zoom-in',
                removalDelay: 300, //delay removal by X to allow out-animation
                callbacks: {
                    beforeOpen: function() {
                        $('#portfolio a').each(function(){
                            $(this).attr('alt', $(this).find('img').attr('alt'));
                        }); 
                    },
                    open: function() {
                        //overwrite default prev + next function. Add timeout for css3 crossfade animation
                        $.magnificPopup.instance.next = function() {
                            var self = this;
                            self.wrap.removeClass('mfp-image-loaded');
                            setTimeout(function() { $.magnificPopup.proto.next.call(self); }, 120);
                        }
                        $.magnificPopup.instance.prev = function() {
                            var self = this;
                            self.wrap.removeClass('mfp-image-loaded');
                            setTimeout(function() { $.magnificPopup.proto.prev.call(self); }, 120);
                        }
                    },
                    imageLoadComplete: function() { 
                        var self = this;
                        setTimeout(function() { self.wrap.addClass('mfp-image-loaded'); }, 16);
                    }
                }
    
            });
    }

    function ms_magnetic($scope) {

        $(document).ready(function () {
            const $hero = $('.magnetic_hero');
            const intensity = 0.9;
            const damping = 0.14;
        
            let globalMouseX = 0, globalMouseY = 0;
            let prevGlobalMouseX = 0, prevGlobalMouseY = 0;
            let globalVelocityX = 0, globalVelocityY = 0;
        
            function updateMousePosition(clientX, clientY) {
                const rect = $hero[0].getBoundingClientRect();
                const centerX = rect.left + rect.width / 50;
                const centerY = rect.top + rect.height / 50;
        
                globalMouseX = clientX - centerX;
                globalMouseY = clientY - centerY;
            }
        
            $hero.on('mousemove', function (e) {
                updateMousePosition(e.clientX, e.clientY);
            });

            $hero.on('touchmove', function (e) {
                const touch = e.originalEvent.touches[0];
                updateMousePosition(touch.clientX, touch.clientY);
            });
        
            function animate() {
                const globalDeltaX = globalMouseX - prevGlobalMouseX;
                const globalDeltaY = globalMouseY - prevGlobalMouseY;
                globalVelocityX += globalDeltaX * intensity;
                globalVelocityY += globalDeltaY * intensity;
                globalVelocityX *= 1 - damping;
                globalVelocityY *= 1 - damping;
                prevGlobalMouseX = globalMouseX;
                prevGlobalMouseY = globalMouseY;
        
                $('.hero__image').each(function () {
                    const $image = $(this);
                    const rect = this.getBoundingClientRect();
                    const imageCenterX = rect.left + rect.width / 2;
                    const imageCenterY = rect.top + rect.height / 2;
                    const localMouseX = globalMouseX - (imageCenterX - $hero[0].getBoundingClientRect().left);
                    const localMouseY = globalMouseY - (imageCenterY - $hero[0].getBoundingClientRect().top);
                    const distance = Math.sqrt(localMouseX ** 2 + localMouseY ** 2);
                    const effectRadius = rect.width;
                    const influence = Math.max(0, Math.min(1, 1 - distance / effectRadius));
                    const maxSpeed = 250;

                    let targetOffsetX = globalVelocityX * influence;
                    let targetOffsetY = globalVelocityY * influence;

                    targetOffsetX = Math.max(Math.min(targetOffsetX, maxSpeed), -maxSpeed);
                    targetOffsetY = Math.max(Math.min(targetOffsetY, maxSpeed), -maxSpeed);

                    $image.css({
                        '--offsetX': `${(targetOffsetX * 2).toFixed(2)}`,
                        '--offsetY': `${(targetOffsetY * 2).toFixed(2)}`,
                        '--velocity': `${((targetOffsetX - targetOffsetY) * -0.35).toFixed(2)}`,
                    });
                });
        
                requestAnimationFrame(animate);
            }
        
            animate();
        });

    }

    function ms_clipboard() {
        $(".share-copy").on('click', function(e){       
            e.preventDefault();
            var copyText = $(this).data('copy-link-url');
            document.addEventListener('copy', function(e) {
               e.clipboardData.setData('text/plain', copyText);
               e.preventDefault();
            }, true);
            document.execCommand('copy');
            $(this).addClass('copied');
            setTimeout(function() { $('.share-button.share-copy').removeClass('copied'); }, 1000); 
        });
    }
    
    // Single Portfolio navigation
    function ms_case_nav() {
        $(document).ready(function () {
            if ($('.ms-spn--prev, .ms-spn--next').length) {
                $('.ms-spn--prev, .ms-spn--next').on('mouseenter', function () {
                    $(this).css('flex-grow', '1');
                    $('.ms-spn--prev, .ms-spn--next').not(this).css('flex-grow', '0');
                });
        
                $('.ms-spn--prev, .ms-spn--next').on('mouseleave', function () {
                    $('.ms-spn--prev, .ms-spn--next').css({ 'flex-grow': '' });
                });
            }
        });
    }
    
    // Theme Mode
    function ms_theme_mode() {
        if ($.exists('.ms_theme_mode')) {
            const themeSwitcher = {
                themeButtons: {
                    dark: $("#theme-dark"),
                    light: $("#theme-light")
                },
                switcher: $("#switcher"),
                body: $('body'),
                
                init: function() {
                    this.themeButtons.dark.on("click", () => this.setTheme('dark'));
                    this.themeButtons.light.on("click", () => this.setTheme('light'));
                    this.switcher.on("click", () => this.toggleTheme());
                },
    
                setTheme: function(theme) {
                    const isDark = theme === 'dark';
                    this.themeButtons.dark.toggleClass("toggler--is-active", isDark);
                    this.themeButtons.light.toggleClass("toggler--is-active", !isDark);
                    this.switcher.prop('checked', !isDark);
                    this.body.attr('data-theme', theme);
                    this.setCookie('theme-mode', theme, 30);
                },
    
                toggleTheme: function() {
                    const newTheme = this.body.attr('data-theme') === 'light' ? 'dark' : 'light';
                    this.setTheme(newTheme);
                },
    
                setCookie: function(name, value, days) {
                    const date = new Date();
                    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));

                    const secureFlag = window.location.protocol === 'https:' ? 'Secure;' : '';
                    document.cookie = `${name}=${value};expires=${date.toUTCString()};path=/;SameSite=Lax;${secureFlag}`;
                }
            };
    
            themeSwitcher.init();
        }
    }
    
    function ms_woo_quantity() {

        if ($.exists('.ms-quantity')) {
            $('body').on('click', '.button-plus, .button-minus', function(e) {
                const isNegative = $(e.target).closest('.button-minus').is('.button-minus');
                const input = $(e.target).closest('.ms-quantity').find('input');
                if (input.is('input')) {
                  input[0][isNegative ? 'stepDown' : 'stepUp']();
                  $('button[name="update_cart"]').prop('disabled', false);
                }
              });
        }
        $('body').on('click', 'button[name="update_cart"], a.remove, button[name="apply_coupon"]', function() {
            $('.woocommerce-notices-wrapper').css('display', 'none');
            setTimeout(function() {

                // Notice animation
                $('.woocommerce-notices-wrapper').css({
                    'display' : 'block'
                });

                // Recal Mini Cart
                var allCountInCart  =  0;
                
                $("input.input-text.qty").each(function() {
                    allCountInCart  = allCountInCart+parseInt($(this).val());
                });

                $('#mini-cart-count span').text(allCountInCart);

            }, 1400);

            // Stop SCrolling after update
            $(document).ajaxComplete(function() {
                if ($('body').hasClass('woocommerce-checkout') || $('body').hasClass('woocommerce-cart')) {
                    jQuery( 'html, body' ).stop();
                }
                if ($('body').hasClass('product-template-default')) {

                    jQuery( 'html, body' ).stop();
                }
            });

          });
            // Stop SCrolling after update
            if ($('body[data-smooth-scroll="on"]').hasClass('product-template-default')) {

                var target = window.location.hash,
                    target = target.replace('#', '');
                window.location.hash = "";
                $(window).load(function() {
                    if (target) {
                        $('html, body').animate({
                            scrollTop: $("#" + target).offset().top
                        }, 600, 'swing', function () {});
                        location.reload();
                    }
                });

            }     
    }

    function ms_woo_category_loop() {
        
        if ($.exists('.product-category')) {
            $('.product-category').wrapAll('<div class="ms-woocommerce-product-category"><div class="ms-category-wrap"><div class="product-category-wrap"></div></div></div>');
        }

    }

    function ms_custom_cursor() {

        const ring = document.querySelector('.ms-cursor-ring');
        const dot  = document.querySelector('.ms-cursor-dot');

        if (!ring || !dot) return; 

        const mouse = { x: innerWidth/2, y: innerHeight/2 };
        let   ringX    = mouse.x,
                ringY    = mouse.y,
                dotX     = mouse.x,
                dotY     = mouse.y,
                lastX    = mouse.x,
                lastY    = mouse.y,
                scaleX   = 1,
                scaleY   = 1,
                hasMoved = false,
                isHidden = false,
                visScale = 0,
                hideTimeout;

        const lerp = (a,b,t) => a + (b-a)*t;

        function onPointerMove(e) {
            const t = e.touches && e.touches[0];
            mouse.x = e.clientX ?? t.clientX;
            mouse.y = e.clientY ?? t.clientY;

            if (!hasMoved) {
            hasMoved = true;
            gsap.to([ring, dot], {
                scale:    1,
                duration: 0.4,
                ease: 'back.out(1.7)'
            });
            }
        }
        window.addEventListener('mousemove', onPointerMove);
        window.addEventListener('touchmove',   onPointerMove);
        window.addEventListener('touchstart',  onPointerMove);

        document.querySelectorAll('a, button, input, .no-cursor, .btn, .ms-hw-inner, .action-menu').forEach(el => {
            el.addEventListener('mouseenter', () => {
            clearTimeout(hideTimeout);
            hideTimeout = setTimeout(() => isHidden = true, 50);
            });
            el.addEventListener('mouseleave', () => {
            clearTimeout(hideTimeout);
            isHidden = false;
            });
        });

        function animate() {
            const dx    = mouse.x - lastX;
            const dy    = mouse.y - lastY;
            const speed = Math.hypot(dx, dy);
            lastX = mouse.x;
            lastY = mouse.y;

            ringX = lerp(ringX, mouse.x, 0.10);
            ringY = lerp(ringY, mouse.y, 0.10);
            dotX  = lerp(dotX,  mouse.x, 0.20);
            dotY  = lerp(dotY,  mouse.y, 0.20);

            const targetScaleX = 1 + speed * 0.02;
            const targetScaleY = 1 - speed * 0.02;
            scaleX = lerp(scaleX, targetScaleX, 0.15);
            scaleY = lerp(scaleY, targetScaleY, 0.15);

            const rot = Math.atan2(dy, dx) * 180 / Math.PI;

            const targetVis = hasMoved && !isHidden ? 1 : 0;
            visScale = lerp(visScale, targetVis, 0.08);

            ring.style.transform = `
            translate3d(${ringX}px, ${ringY}px, 0)
            rotate(${rot}deg)
            scale(${scaleX * visScale}, ${scaleY * visScale})
            `;

            dot.style.transform = `
            translate3d(${dotX}px, ${dotY}px, 0)
            scale(${visScale})
            `;

            requestAnimationFrame(animate);
        }

        requestAnimationFrame(animate);


    }

// Portfolio filter-navigation

 function Util () {};

 // class manipulation functions
 Util.hasClass = function(el, className) {
     if (el.classList) return el.classList.contains(className);
     else return !!el.className.match(new RegExp('(\\s|^)' + className + '(\\s|$)'));
 };
 
 Util.addClass = function(el, className) {
     var classList = className.split(' ');
     if (el.classList) el.classList.add(classList[0]);
     else if (!Util.hasClass(el, classList[0])) el.className += " " + classList[0];
     if (classList.length > 1) Util.addClass(el, classList.slice(1).join(' '));
 };
 
 Util.removeClass = function(el, className) {
     var classList = className.split(' ');
     if (el.classList) el.classList.remove(classList[0]);  
     else if(Util.hasClass(el, classList[0])) {
         var reg = new RegExp('(\\s|^)' + classList[0] + '(\\s|$)');
         el.className=el.className.replace(reg, ' ');
     }
     if (classList.length > 1) Util.removeClass(el, classList.slice(1).join(' '));
     };
 
 Util.toggleClass = function(el, className, bool) {
     if(bool) Util.addClass(el, className);
     else Util.removeClass(el, className);
     };
 
 Util.setAttributes = function(el, attrs) {
     for(var key in attrs) {
         el.setAttribute(key, attrs[key]);
     }
 };

(function() {
    var FilterNav = function(element) {
        this.element      = element;
        this.wrapper      = this.element.getElementsByClassName('js-filter-nav__wrapper')[0];
        this.nav          = this.element.getElementsByClassName('js-filter-nav__nav')[0];
        this.list         = this.nav.getElementsByClassName('js-filter-nav__list')[0];
        this.control      = this.element.getElementsByClassName('js-filter-nav__control')[0];
        this.modalClose   = this.element.getElementsByClassName('js-filter-nav__close-btn')[0];
        this.placeholder  = this.element.getElementsByClassName('js-filter-nav__placeholder')[0];
        this.marker       = this.element.getElementsByClassName('js-filter-nav__marker');
        this.layout       = 'expanded';
        initFilterNav(this);
    };

    function initFilterNav(element) {
        checkLayout(element);  // initial
        if (element.layout === 'expanded') placeMarker(element);

        element.element.addEventListener('update-layout', function() {
            checkLayout(element);
        });

        element.wrapper.addEventListener('click', function(event) {
            var newItem = event.target.closest('.js-filter-nav__btn');
            if (newItem) {
                updateCurrentItem(element, newItem);
                return;
            }
            if (Util.hasClass(event.target, 'js-filter-nav__wrapper') ||
                event.target.closest('.js-filter-nav__close-btn')
            ) {
                toggleModalList(element, false);
            }
        });

        element.control.addEventListener('click', function(){
            toggleModalList(element, true);
        });

        window.addEventListener('keyup', function(event) {
            var key = event.key || event.keyCode;
            // ESC
            if (key === 'Escape' || key === 27) {
                if (element.control.getAttribute('aria-expanded') === 'true' &&
                    isVisible(element.control)
                ) {
                    toggleModalList(element, false);
                }
            }
            // TAB
            if (key === 'Tab' || key === 9) {
                if (element.control.getAttribute('aria-expanded') === 'true' &&
                    isVisible(element.control) &&
                    !document.activeElement.closest('.js-filter-nav__wrapper')
                ) {
                    toggleModalList(element, false);
                }
            }
        });
    }

    function updateCurrentItem(element, btn) {
        if (btn.getAttribute('aria-current') === 'true') {
            toggleModalList(element, false);
            return;
        }
        var activeBtn = element.wrapper.querySelector('[aria-current]');
        if (activeBtn) activeBtn.removeAttribute('aria-current');
        btn.setAttribute('aria-current', 'true');
        element.placeholder.textContent = btn.textContent;
        toggleModalList(element, false);
        if (element.layout === 'expanded') placeMarker(element);
    }

    function toggleModalList(element, bool) {
        element.control.setAttribute('aria-expanded', bool);
        Util.toggleClass(element.wrapper, 'filter-nav__wrapper--is-visible', bool);
        if (bool) {
            element.nav.querySelectorAll('[href], button:not([disabled])')[0].focus();
        } else if (isVisible(element.control)) {
            element.control.focus();
        }
    }

    function isVisible(el) {
        return (el.offsetWidth || el.offsetHeight || el.getClientRects().length);
    }

    function checkLayout(element) {
        var isMobile = window.innerWidth <= 1023;

        if (isMobile) {
            // always collapsed on mobile
            if (element.layout !== 'collapsed') {
                element.layout = 'collapsed';
                Util.removeClass(element.element, 'filter-nav--expanded');
                Util.addClass   (element.element, 'filter-nav--collapsed');
                Util.removeClass(element.modalClose, 'is-hidden');
                Util.removeClass(element.control,   'is-hidden');
            }
        } else {
            // desktop: original logic
            if (element.layout === 'expanded' && switchToCollapsed(element)) {
                element.layout = 'collapsed';
                Util.removeClass(element.element, 'filter-nav--expanded');
                Util.addClass   (element.element, 'filter-nav--collapsed');
                Util.removeClass(element.modalClose, 'is-hidden');
                Util.removeClass(element.control,    'is-hidden');
            } 
            else if (element.layout === 'collapsed' && switchToExpanded(element)) {
                element.layout = 'expanded';
                Util.addClass   (element.element, 'filter-nav--expanded');
                Util.removeClass(element.element, 'filter-nav--collapsed');
                Util.addClass   (element.modalClose, 'is-hidden');
                Util.addClass   (element.control,    'is-hidden');
            }
        }

        // place marker if expanded
        if (element.layout === 'expanded') {
            placeMarker(element);
        }
    }

    function switchToCollapsed(element) {
        return element.nav.scrollWidth > element.nav.offsetWidth;
    }

    function switchToExpanded(element) {
        element.element.style.visibility = 'hidden';
        Util.addClass(element.element, 'filter-nav--expanded');
        Util.removeClass(element.element, 'filter-nav--collapsed');
        var canExpand = element.nav.scrollWidth <= element.nav.offsetWidth;
        Util.removeClass(element.element, 'filter-nav--expanded');
        Util.addClass(element.element, 'filter-nav--collapsed');
        element.element.style.visibility = 'visible';
        return canExpand;
    }

    function placeMarker(element) {
        var activeElement = element.wrapper.querySelector('.js-filter-nav__btn[aria-current="true"]');
        if (element.marker.length === 0 || !activeElement) return;
        var width = activeElement.offsetWidth - 2;
        var offsetX = activeElement.getBoundingClientRect().left - element.list.getBoundingClientRect().left;
        element.marker[0].style.width = 'calc(' + width + 'px)';
        element.marker[0].style.transform = 'translateX(' + offsetX + 'px)';
    }

    // INIT ALL FILTER NAVs
    var filterNav = document.getElementsByClassName('js-filter-nav');
    if (filterNav.length > 0) {
        var instances = [], i, resizeTimer,
            updateEvent = new CustomEvent('update-layout');

        for (i = 0; i < filterNav.length; i++) {
            instances.push(new FilterNav(filterNav[i]));
        }

        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                instances.forEach(function(inst) {
                    inst.element.dispatchEvent(updateEvent);
                });
            }, 100);
        });

        if (document.fonts && document.fonts.onloadingdone) {
            document.fonts.onloadingdone = function() {
                instances.forEach(function(inst) {
                    inst.element.dispatchEvent(updateEvent);
                });
            };
        }
    }
})();


})(jQuery);

// Swiper Lightbox debug
jQuery(function($){
  $('a[data-elementor-open-lightbox="yes"]').on('click', function() {
    setTimeout(function() {
      var $img = $('.swiper-zoom-container img.elementor-lightbox-image');

      if ($img.length) {
        var dataSrc = $img.attr('data-src');
        if (dataSrc && !$img.attr('src')) {
          $img.attr('src', dataSrc);
        }
      }
    }, 50);
  });
});