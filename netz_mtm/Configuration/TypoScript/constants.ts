
plugin.tx_netzmtm {
    view {
        # cat=plugin.tx_netzmtm/file; type=string; label=Path to template root (FE)
        templateRootPath = EXT:netz_mtm/Resources/Private/Templates/
        # cat=plugin.tx_netzmtm/file; type=string; label=Path to template partials (FE)
        partialRootPath = EXT:netz_mtm/Resources/Private/Partials/
        # cat=plugin.tx_netzmtm/file; type=string; label=Path to template layouts (FE)
        layoutRootPath = EXT:netz_mtm/Resources/Private/Layouts/
    }
    persistence {
        # cat=plugin.tx_netzmtm//a; type=string; label=Default storage PID
        storagePid =
    }

    settings {
        # cat=plugin.tx_netzmtm/a; type=string; label= Youtube All Video Page id
        allvideo_page_id = 72

        # cat=plugin.tx_netzmtm/a; type=string; label= Youtube PID
        youtube_pid = 71

         # cat=plugin.tx_netzmtm/a; type=string; label= Matchcenter PID
        matchcenter_pid = 3

         # cat=plugin.tx_netzmtm/a; type=string; label= Spielpläne PID
        spielplne_pid = 22

         # cat=plugin.tx_netzmtm/a; type=string; label= Tabellen PID
        tabellen_pid = 23

         # cat=plugin.tx_netzmtm/a; type=string; label= Statistiken PID
        statistiken_pid = 24

         # cat=plugin.tx_netzmtm/a; type=string; label= Appuser PID
        appuser_pid = 24

           # cat=plugin.tx_netzmtm/a; type=string; label= Sender Email
        sender_email = typo3testing02@gmail.com

           # cat=plugin.tx_netzmtm/a; type=string; label= Base url
        base_url_pid = http://p551477.webspaceconfig.de


        # cat=plugin.tx_netzmtm/a; type=boolean; label= Sportradar Access Level Production
        sportradar_access = 0

        # cat=plugin.tx_netzmtm/a; type=string; label= Sportradar Access Key
        sportradar_access_key = ywpuj44gj2f9qnq4mqr7cskj

        # cat=plugin.tx_netzmtm/a; type=string; label= Sportradar Competitor ID
        sportradar_competitor_id = sr:competitor:4007

        # cat=plugin.tx_netzmtm/a; type=string; label= News Detail Page
        news_detail_page = 68

    }

}
