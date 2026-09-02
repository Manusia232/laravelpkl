<footer class="site-footer">
    <div class="site-footer__container">

        <div class="site-footer__brand">
            <img
                src="https://abbastesting.rf.gd/fotomob/isi/6f1e73d0-94eb-4250-a14e-9e14141791f0.jpg"
                alt="EVERSUS"
                class="site-footer__logo"
            >

            <span class="site-footer__title">EVERSUS</span>
        </div>

        <div class="site-footer__content">

            <div class="site-footer__row">
                <a href="#" class="site-footer__link">Home</a>
                <a href="#" class="site-footer__link">Bandingkan</a>
                <a href="#" class="site-footer__link">Tentang kami</a>

                <a
                    href="https://web.facebook.com/profile.php?id=61593952862947"
                    target="_blank"
                    rel="noopener"
                    class="site-footer__link"
                >
                    <img
                        src="https://img.icons8.com/?size=512&id=118497&format=png"
                        alt="Facebook"
                    >
                    Facebook
                </a>

                <a
                    href="https://www.instagram.com/eversusreal/"
                    target="_blank"
                    rel="noopener"
                    class="site-footer__link"
                >
                    <img
                        src="https://img.icons8.com/?size=512&id=32323&format=png"
                        alt="Instagram"
                    >
                    Instagram
                </a>
            </div>

            <div class="site-footer__row">
                <span class="site-footer__copyright">
                    © 2026-akhir
                </span>

                <a
                    href="https://EVKU.rf.gd"
                    target="_blank"
                    class="site-footer__link"
                >
                    eversus.rf.gd
                </a>

                <a href="#" class="site-footer__link">EV Finder</a>
                <a href="#" class="site-footer__link">Privacy</a>
                <a href="#" class="site-footer__link">Terms of use</a>
            </div>

        </div>

        <div class="site-footer__credits">
            Di kembangkan oleh<br>
            <strong>abbas.rf.gd</strong>
        </div>

    </div>
</footer>

<style>
    /* ================================
       FOOTER ONLY
       Tidak memengaruhi halaman lain
       ================================ */

    .site-footer {
        width: 100%;
        background-color: #ffffff;
        border-top: 1px solid #e5e5e5;
        padding: 24px 40px;
        color: #333333;
        font-size: 14px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    }

    .site-footer *,
    .site-footer *::before,
    .site-footer *::after {
        box-sizing: border-box;
    }

    .site-footer__container {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;

        display: flex;
        align-items: center;
        justify-content: flex-start;

        gap: 100px;
        flex-wrap: wrap;
    }

    /* BRAND */

    .site-footer__brand {
        display: flex;
        align-items: center;
        gap: 12px;

        padding-right: 24px;
        border-right: 1px solid #e0e0e0;

        flex-shrink: 0;
    }

    .site-footer__logo {
        width: 50px;
        height: 40px;

        object-fit: cover;
        display: block;
    }

    .site-footer__title {
        font-size: 26px;
        font-weight: 800;
        letter-spacing: 1px;
        color: #000000;
        white-space: nowrap;
    }

    /* CONTENT */

    .site-footer__content {
        display: flex;
        flex-direction: column;

        gap: 10px;

        flex: 1;
        min-width: 250px;
    }

    .site-footer__row {
        display: flex;
        align-items: center;

        gap: 20px;

        flex-wrap: wrap;
    }

    /* LINK */

    .site-footer__link {
        color: #555555;
        text-decoration: none;

        display: inline-flex;
        align-items: center;

        gap: 6px;

        transition: color 0.2s ease;
    }

    .site-footer__link:hover {
        color: #000000;
    }

    .site-footer__link img {
        width: 20px;
        height: 20px;

        object-fit: contain;
        display: block;
    }

    /* COPYRIGHT */

    .site-footer__copyright {
        color: #666666;
    }

    /* CREDITS */

    .site-footer__credits {
        padding-left: 24px;

        border-left: 1px solid #e0e0e0;

        color: #555555;
        line-height: 1.5;

        flex-shrink: 0;
    }

    .site-footer__credits strong {
        font-weight: 700;
        color: #333333;
    }

    /* RESPONSIVE */

    @media (max-width: 768px) {

        .site-footer {
            padding: 24px 20px;
        }

        .site-footer__container {
            flex-direction: column;
            align-items: flex-start;

            gap: 16px;
        }

        .site-footer__brand {
            border-right: none;
            padding-right: 0;
        }

        .site-footer__credits {
            border-left: none;
            padding-left: 0;
        }

        .site-footer__content {
            width: 100%;
        }

        .site-footer__row {
            gap: 12px;
        }
    }
</style>
