/* MUSLI STYLES */
/* <?php echo date('l jS \of F Y h:i:s A'); ?> */

<?php if($css_options['hide_on_width'] != '0'): ?>
@media (max-width:<?php echo $css_options['hide_on_width']; ?>px){
    .musli {
        display: none;
    }
}
<?php endif; ?>
.musli *{
    padding:0;
    margin:0;
    list-style:none;
    color: #444;
}
.musli{
    top: <?php echo $css_options['margin_b_edge']; ?>%;
    position:fixed;
    right:0px;
    z-index:100;
    list-style:none;
}
.musli-bottom{
    bottom:0px;
    right:auto;
    top:auto;
    left:<?php echo $css_options['margin_b_edge']; ?>%;
}
.musli-top{
    top:0px;
    right:auto;
    bottom:auto;
    left:<?php echo $css_options['margin_b_edge']; ?>%;
}
.musli-left{
    left:0px;
    top: <?php echo $css_options['margin_b_edge']; ?>%;
    right:auto;
    bottom:auto;
}
.musli > li{
    margin-bottom: <?php echo $css_options['margin_b_tabs']; ?>px;
    width: <?php echo $css_options['icon_width']; ?>px;
    height: <?php echo $css_options['icon_height']; ?>px;
    position:relative;
}
.musli-bottom > li, .musli-top > li{
    margin-right: 1px;
    margin-bottom: 0;
    float:left;
    margin-right: <?php echo $css_options['margin_b_tabs']; ?>px;
}
.musli > li > span{
    overflow:hidden;
    display:block;
    font-size:0;
    cursor:pointer;
<?php if($css_options['rounded_corners'] == 'on'): ?>
    -moz-border-radius: 5px 0 0 5px;
    -webkit-border-radius: 5px 0 0 5px;
    border-radius: 5px 0 0 5px;
<?php endif; ?>
    height: 100%;
    text-align:center;
    font-size:20px;
}
.musli > li > span > i{
    line-height: <?php echo $css_options['icon_height']; ?>px;
    color: #ffffff;
}
<?php if($css_options['rounded_corners'] == 'on'): ?>
.musli-bottom > li > span{
    -moz-border-radius: 5px 5px 0 0;
    -webkit-border-radius: 5px 5px 0 0;
    border-radius: 5px 5px 0 0;
}
.musli-top > li > span{
    -moz-border-radius: 0 0 5px 5px;
    -webkit-border-radius: 0 0 5px 5px;
    border-radius: 0 0 5px 5px;
}
.musli-left > li > span{
    -moz-border-radius: 0 5px 5px 0;
    -webkit-border-radius: 0 5px 5px 0;
    border-radius: 0 5px 5px 0;
}
<?php endif; ?>
.musli > li > div{
    padding: <?php echo $css_options['padding']; ?>px;
    background: <?php echo $css_options['background_color']; ?>;
    float: left;
    width: <?php echo $css_options['width']; ?>px;
    height: <?php echo $css_options['height']; ?>px;
<?php if($css_options['rounded_corners'] == 'on'): ?>
    -moz-border-radius: 0 0 0 8px;
    -webkit-border-radius: 0 0 0 8px;
    border-radius: 0 0 0 8px;
<?php endif; ?>
    position: absolute;
    top: 0;
    z-index: 100;
    border: solid <?php echo $css_options['border_color']; ?> <?php echo $css_options['border_width']; ?>px;
    left: <?php echo $css_options['icon_width']; ?>px;
}
.musli-bottom > li > div{
    top: <?php echo $css_options['icon_height']; ?>px;
    left:auto;
<?php if($css_options['rounded_corners'] == 'on'): ?>
    -moz-border-radius: 0 8px 0 0;
    -webkit-border-radius: 0 8px 0 0;
    border-radius: 0 8px 0 0;
<?php endif; ?>
}
.musli-top > li > div{
    left:auto;
    top:auto;
<?php if($css_options['rounded_corners'] == 'on'): ?>
    -moz-border-radius: 0 0 8px 0;
    -webkit-border-radius: 0 0 8px 0;
    border-radius: 0 0 8px 0;
<?php endif; ?>
    bottom:<?php echo $css_options['icon_height']; ?>px;
}
.musli-left > li > div{
    top:0px;
    left:auto;
    right: <?php echo $css_options['icon_width']; ?>px;
<?php if($css_options['rounded_corners'] == 'on'): ?>
    -moz-border-radius: 0 0 8px 0;
    -webkit-border-radius: 0 0 8px 0;
    border-radius: 0 0 8px 0;
<?php endif; ?>
}