<style>
    .demo-drawer {
        width: 300px;
        position: fixed;
        top: 0;
        height: 100%;
        z-index: 999998;
        background-color: #fafafa;
        right: -310px;
        transition: all .2s;
        color: #455a64;
        box-shadow: 0 8px 10px 1px rgba(0,0,0,.14), 0 3px 14px 2px rgba(0,0,0,.12), 0 5px 5px -3px rgba(0,0,0,.4);
    }
    .demo-drawer *, .demo-drawer *:after, .demo-drawer *:before {
        box-sizing: border-box;
    }
    .demo-drawer.open {
        display: block;
        right: 0;
    }
    .demo-drawer-wrapper{
        position: relative;
        width: 100%;
        height: 100%;
    }
    .demo-drawer-body {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        padding: 15px;
        text-align: center;
        overflow-y: auto;
        overflow-x: hidden;
    }

    .demo-thumb-wrapper{
        position: relative;
        background: #f8f8f8;
        border-radius: 4px;
        box-shadow: 0 0 2px 1px rgba(0,0,0,0.2);
        margin-bottom: 25px;
        overflow: hidden;
    }
    .demo-thumb-wrapper img{
        width:100%;
        height: auto;
    }
    .demo-thumb-wrapper span{
        position:absolute;
        left:0;
        bottom:0;
        padding: 6px 10px;
        background-color: rgba(0, 0, 0, 0.7);
        color: #fff;
        font-weight: 700
    }
    .demo-thumb-wrapper:hover{
        background: #f1f1f1;
        box-shadow: 0 0 2px 1px rgba(0,0,0,0.4);
    }

     .demo-drawer-opener{
        position: absolute;
        top: 20%;
        right: 100%;
        padding: 12px 20px 12px 10px;
        text-align: center;
        font-size: 13px;
        vertical-align: middle;
        background-color: inherit;
        background-color: #000000;
        color: #ffffff;
        font-weight: bold;
        -webkit-box-shadow: 1px 0 7px rgba(0,0,0,.2);
        box-shadow: 1px 0 7px rgba(0,0,0,.2);
        border-top-left-radius: 5px;
        border-bottom-left-radius: 5px;
    }

    .demo-drawer-header{
        padding: 15px 0;
    }

    .demo-drawer-header .demo-drawer-logo{
        font-size: 20px;
        font-weight: bold;
    }

    .demo-drawer-content {
        overflow-x: auto;
    }
    .demo-purchase-btn{
        display: block;
        background-color:rgba(22, 126, 187);
        color: #fff;
        padding: 10px 20px;
        text-align: center;
        margin-top: 10px;
        margin-bottom: 20px;
        border-radius: 3px
    }
</style>
<div class="demo-drawer">
    <a href="#" rel="nofollow" class="demo-drawer-opener">Themes</a>

    <div class="demo-drawer-wrapper">
    <div class="demo-drawer-body">
    <div class="demo-drawer-header clearfix">
        <div class="demo-drawer-logo">Buzzy Themes</div>
        <p class="demo-drawer-intro">5 ready demos which can be installed as simple as with 1 click.</p>
        <a href="https://codecanyon.net/item/buzzy-bundle-viral-media-script/18754835" target=_blank class="demo-purchase-btn">Purchase Now</a>
    </div>
    <div  class="demo-drawer-content clearfix">
        <div class="demo-thumb-wrapper">
            <a href="{{ url('/?theme=modern') }}" title="Modern Buzzy Theme">
                <img src="https://cdn.akbilisim.com/products/buzzy-laravel/images/themes/modern.jpg" height="300" width="300" class="img-responsive" alt="Modern Buzzy Theme">
            </a>
            <span>Modern Buzzy Theme</span>
        </div>
        <div class="demo-thumb-wrapper">
            <a href="{{ url('/?theme=buzzyfeed') }}" title="BuzzyFeed">
                <img src="https://cdn.akbilisim.com/products/buzzy-laravel/images/themes/buzzyfeed.jpg" height="300" width="300" class="img-responsive" alt="BuzzyFeed">
            </a>
            <span>BuzzyFeed</span>
        </div>
        <div class="demo-thumb-wrapper">
            <a href="{{ url('/?theme=viralmag') }}" title="ViralMag">
                <img src="https://cdn.akbilisim.com/products/buzzy-laravel/images/themes/viralmag.jpg" height="300" width="300" class="img-responsive" alt="ViralMag">
            </a>
            <span>ViralMag</span>
        </div>
        <div class="demo-thumb-wrapper">
            <a href="{{ url('/?theme=boxed') }}" title="Boxed">
                <img src="https://cdn.akbilisim.com/products/buzzy-laravel/images/themes/boxed.jpg" height="300" width="300" class="img-responsive" alt="Boxed">
            </a>
            <span>Boxed</span>
        </div>
        <div class="demo-thumb-wrapper">
            <a href="{{ url('/?theme=default') }}" title="Classic Buzzy Theme">
                <img src="https://cdn.akbilisim.com/products/buzzy-laravel/images/themes/default.jpg" height="300" width="300" class="img-responsive" alt="Classic Buzzy Theme">
            </a>
            <span>Classic(Old) Buzzy Theme</span>
        </div>
        <div class="demo-thumb-wrapper">
            <img src="https://cdn.akbilisim.com/products/buzzy-laravel/images/themes/comingsoon.jpg" height="300" width="300" class="img-responsive" alt="Coming Soon">
            <span>Coming Soon</span>
        </div>
    </div>
    <div class="demo-thumb-footer" >
    </div>
</div>
</div>
</div>
<script>
 $(function() {
    'use strict';
    jQuery('.demo-drawer-opener').on('click', function() {
        jQuery('.demo-drawer').toggleClass('open');
    })
});
</script>
