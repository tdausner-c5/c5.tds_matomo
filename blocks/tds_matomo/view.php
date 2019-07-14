<?php defined('C5_EXECUTE') or die('Access Denied.');

if (Page::getCurrentPage()->isEditMode())
{
    echo '<pre>'.t('Place holder for Matomo embedding (contains no visible content)').'</pre>';
}

?>

<script type="text/javascript">
    var _paq = _paq || [];
    /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
    _paq.push( ['trackPageView'] );
    _paq.push( ['enableLinkTracking'] );
    ( function () {
        var u = "//<?php echo $url ?>/";
        _paq.push( ['setTrackerUrl', u + 'piwik.php'] );
        _paq.push( ['setSiteId', '<?php echo $websiteId ?>'] );
        var d = document, g = d.createElement( 'script' ), s = d.getElementsByTagName( 'script' )[0];
        g.type = 'text/javascript';
        g.async = true;
        g.defer = true;
        g.src = u + 'piwik.js';
        s.parentNode.insertBefore( g, s );
    } )();
</script>
