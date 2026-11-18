<div class="modal fade" id="settingsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content settings-modal">
            <div class="modal-header">
                <h5 class="modal-title">Be&aacute;ll&iacute;t&aacute;sok</h5>
                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Bez&aacute;r&aacute;s">
                </button>
            </div>

            <div class="modal-body">
                <div class="settings-layout">
                    <div class="settings-sidebar">
                        <div class="nav nav-pills flex-column" id="settings-tabs" role="tablist">

                            <button class="nav-link active"
                                    id="general-tab"
                                    data-bs-toggle="pill"
                                    data-bs-target="#general-settings"
                                    type="button"
                                    role="tab">
                                &Aacute;ltal&aacute;nos
                            </button>

                            <button class="nav-link"
                                    id="theme-tab"
                                    data-bs-toggle="pill"
                                    data-bs-target="#theme-settings"
                                    type="button"
                                    role="tab">
                                T&eacute;ma
                            </button>

                        </div>
                    </div>

                    <div class="settings-content">
                        <div class="tab-content">

                            <div class="tab-pane fade show active"
                                 id="general-settings"
                                 role="tabpanel">
                            </div>

                            
                            <div class="tab-pane fade" id="theme-settings" role="tabpanel">
                                <h5>V&aacute;lassz t&eacute;m&aacute;t</h5>
                                <p class="text-muted">
                                    A kiv&aacute;lasztott t&eacute;ma az eg&eacute;sz oldalon &eacute;rv&eacute;nyes&uuml;l.
                                </p>

                                <div class="theme-options">
                                    <button type="button" class="theme-option" data-theme-choice="green">
                                        <span class="theme-color green"></span>
                                        <span>Z&ouml;ld</span>
                                    </button>

                                    <button type="button" class="theme-option" data-theme-choice="blue">
                                        <span class="theme-color blue"></span>
                                        <span>K&eacute;k</span>
                                    </button>

                                    <button type="button" class="theme-option" data-theme-choice="purple">
                                        <span class="theme-color purple"></span>
                                        <span>Lila</span>
                                    </button>

                                    <button type="button" class="theme-option" data-theme-choice="red">
                                        <span class="theme-color red"></span>
                                        <span>Piros</span>
                                    </button>

                                    <button type="button" class="theme-option" data-theme-choice="orange">
                                        <span class="theme-color orange"></span>
                                        <span>Narancs</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>