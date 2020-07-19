
plugin.tx_netzmtm {
    view {
        templateRootPaths.0 = EXT:netz_mtm/Resources/Private/Templates/
        templateRootPaths.1 = {$plugin.tx_netzmtm.view.templateRootPath}
        partialRootPaths.0 = EXT:netz_mtm/Resources/Private/Partials/
        partialRootPaths.1 = {$plugin.tx_netzmtm.view.partialRootPath}
        layoutRootPaths.0 = EXT:netz_mtm/Resources/Private/Layouts/
        layoutRootPaths.1 = {$plugin.tx_netzmtm.view.layoutRootPath}
    }
    persistence {
        storagePid = {$plugin.tx_netzmtm.persistence.storagePid}
        #recursive = 1
    }
    features {
        #skipDefaultArguments = 1
        # if set to 1, the enable fields are ignored in BE context
        ignoreAllEnableFieldsInBe = 0
        # Should be on by default, but can be disabled if all action in the plugin are uncached
        requireCHashArgumentForActionArguments = 1
    }
    mvc {
        #callDefaultActionIfActionCantBeResolved = 1
    }
    settings {

        allvideo_page_id = {$plugin.tx_netzmtm.settings.allvideo_page_id}
        youtube_pid = {$plugin.tx_netzmtm.settings.youtube_pid}
        base_url_pid = {$plugin.tx_netzmtm.settings.base_url_pid}
        sportradar_access = {$plugin.tx_netzmtm.settings.sportradar_access}
        sportradar_access_key = {$plugin.tx_netzmtm.settings.sportradar_access_key}
        sportradar_competitor_id = {$plugin.tx_netzmtm.settings.sportradar_competitor_id}
        matchcenter_pid = {$plugin.tx_netzmtm.settings.matchcenter_pid}
        spielplne_pid = {$plugin.tx_netzmtm.settings.spielplne_pid}
        tabellen_pid = {$plugin.tx_netzmtm.settings.tabellen_pid}
        statistiken_pid = {$plugin.tx_netzmtm.settings.statistiken_pid}
        appuser_pid = {$plugin.tx_netzmtm.settings.appuser_pid}
        sender_email = {$plugin.tx_netzmtm.settings.sender_email}
        news_detail_page = {$plugin.tx_netzmtm.settings.news_detail_page}
    }
}

page.includeJSFooter {
  netz_mtm_js = EXT:netz_mtm/Resources/Public/Js/filter_search.js
  netz_mtm_app_js = EXT:netz_mtm/Resources/Public/Js/filter_app.js

}
page.includeCSS {
    netz_mtm_css = EXT:netz_mtm/Resources/Public/Css/style.css
}
