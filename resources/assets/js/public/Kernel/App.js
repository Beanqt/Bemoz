window.dataLayer = window.dataLayer || [];

var app = new (function(){
    this.csrf = $('meta[name="csrf-token"]').attr('content');
    this.head = $('head');
    this.document = $(document);
    this.html = $('html');
    this.views = new Views();
    this.watches = [];

    $(function(){
        app.run();
    });

    this.run = function(){
        this.body = $('body');
        this.loadPlugins();
        this.watching();
        this.loadGDPR();
        this.body.removeClass('loading').find('>.loader').removeClass('active');
    };

    this.loadPlugins = function(){
        this.views.animate();
        this.views.filebox();
        this.views.select();
        this.views.embed();
        this.views.widgetTab();
    };

    this.watch = function(callback){
        this.watches.push(callback);
    };

    this.watching = function(){
        var self = this;
        this.cookie = $('.cookieBox');

        if(!checkCookie('cookieBox')) {
            this.cookie.addClass('active');
        }

        this.cookie.find('.cookieBtn').click(function(){
            setCookie('cookieBox', true, 30);
            $('#deleteCookie').removeClass('hidden');

            $('.cookieBox').slideUp('slow', function(){
                $(this).removeClass('active');
            });

            self.loadGDPR();
        });

        this.cookie.find('.cookieBtnCancel').click(function(){
            setCookie('cookieBox', false, 30);

            self.cookie.slideUp('slow', function(){
                $(this).removeClass('active');
            });
        });

        for(var i = 0; i < this.watches.length; i++){
            this.watches[i]();
        }
    };
    this.loadGDPR = function(){
        if(getCookie('cookieBox') == 'true'){
            if(!empty(settings.ga)){
                (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

                ga('create', settings.ga, 'auto');
                ga('send', 'pageview');

                this.ga = true;
            }

            if(!empty(settings.gtm)){
                (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
                })(window,document,'script','dataLayer',settings.gtm);

                this.gtm = true;
            }

            if(!empty(settings.ga4)){
                (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                })(window,document,'script','https://www.googletagmanager.com/gtag/js?id='+settings.ga4,'ga');

                gtag('js', new Date());
                gtag('config', settings.ga4);

                this.ga4 = true;
            }

            if(!empty(settings.fb)){
                !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                    n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
                    n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
                    t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
                    document,'script','https://connect.facebook.net/en_US/fbevents.js');

                fbq('init', settings.fb);
                fbq('track', 'PageView');

                this.fb = true;
            }
            addGPDR();
        }
    };
});