<style>
    /* ---------- Buttons / Badges (stile coerente) ---------- */
    .btn {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        border-radius: 14px;
        padding: .55rem .9rem;
        font-weight: 600;
        font-size: .875rem;
        transition: .15s
    }

    .btn-light {
        background: #fff;
        border: 1px solid rgb(226 232 240);
        color: rgb(15 23 42);
        box-shadow: 0 1px 0 rgba(15, 23, 42, .03)
    }

    .btn-light:hover {
        background: rgb(248 250 252)
    }

    .btn-primary {
        background: rgb(15 23 42);
        color: #fff;
        border: 1px solid rgb(15 23 42)
    }

    .btn-primary:hover {
        opacity: .95
    }

    .btn-danger {
        background: rgb(185 28 28);
        color: #fff;
        border: 1px solid rgb(185 28 28)
    }

    .btn-danger:hover {
        opacity: .95
    }

    .btn-muted {
        background: rgb(241 245 249);
        color: rgb(51 65 85);
        border: 1px solid rgb(226 232 240)
    }

    .btn-muted:hover {
        background: rgb(226 232 240)
    }

    .btn:disabled {
        opacity: .55;
        cursor: not-allowed
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        border-radius: 999px;
        padding: .25rem .6rem;
        font-weight: 700;
        font-size: .75rem
    }

    .badge-ok {
        background: rgb(236 253 245);
        color: rgb(6 95 70);
        border: 1px solid rgb(167 243 208)
    }

    .badge-muted {
        background: rgb(241 245 249);
        color: rgb(51 65 85);
        border: 1px solid rgb(226 232 240)
    }

    /* ---------- Panel ---------- */
    .sor-content-panel {
        border: 1px solid rgb(226 232 240);
        background: #fff;
        border-radius: 20px;
        padding: 18px;
        box-shadow: 0 1px 0 rgba(15, 23, 42, .03);
    }

    /* ---------- Horizontal nav (come segnalazioni) ---------- */
    .sor-hnav {
        border: 1px solid rgb(226 232 240);
        background: linear-gradient(180deg, #fff, rgb(248 250 252));
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 1px 0 rgba(15, 23, 42, .03);
    }

    .sor-hnav__top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 12px 14px;
        border-bottom: 1px solid rgb(226 232 240)
    }

    .sor-hnav__title {
        font-weight: 800;
        color: rgb(15 23 42);
        font-size: .95rem
    }

    .sor-hnav__cats {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        justify-content: flex-end
    }

    .sor-cat-tab {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        border-radius: 999px;
        padding: .35rem .65rem;
        background: #fff;
        border: 1px solid rgb(226 232 240);
        color: rgb(51 65 85);
        font-weight: 800;
        font-size: .78rem;
        box-shadow: 0 1px 0 rgba(15, 23, 42, .02);
    }

    .sor-cat-tab:hover {
        background: rgb(248 250 252)
    }

    .sor-cat-tab.is-active {
        background: rgb(15 23 42);
        border-color: rgb(15 23 42);
        color: #fff
    }

    .sor-cat-tab__count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 22px;
        height: 18px;
        padding: 0 .35rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, .35);
        color: inherit;
        font-size: .72rem;
        font-weight: 900;
    }

    .sor-cat-tab.is-active .sor-cat-tab__count {
        background: rgba(255, 255, 255, .2)
    }

    .sor-hnav__rail {
        overflow: auto;
        white-space: nowrap;
        padding: 10px 12px;
        scroll-behavior: smooth;
    }

    .sor-hnav__rail::-webkit-scrollbar {
        height: 10px
    }

    .sor-hnav__rail::-webkit-scrollbar-thumb {
        background: rgb(226 232 240);
        border-radius: 999px
    }

    .sor-hnav__rail.is-dragging {
        cursor: grabbing
    }

    .sor-hnav__group {
        display: none;
        gap: 10px;
        align-items: center
    }

    .sor-hnav__group.is-active {
        display: inline-flex
    }

    .sor-pill {
        display: inline-flex;
        align-items: center;
        gap: .55rem;
        padding: .55rem .75rem;
        border-radius: 999px;
        background: #fff;
        border: 1px solid rgb(226 232 240);
        color: rgb(30 41 59);
        font-weight: 800;
        font-size: .85rem;
        box-shadow: 0 1px 0 rgba(15, 23, 42, .02);
        transition: .15s;
    }

    .sor-pill:hover {
        background: rgb(248 250 252);
        transform: translateY(-1px)
    }

    .sor-pill.is-active {
        background: rgb(15 23 42);
        border-color: rgb(15 23 42);
        color: #fff
    }

    .sor-pill__ico {
        width: 18px;
        height: 18px;
        opacity: .9
    }

    .sor-pill__txt {
        max-width: 220px;
        overflow: hidden;
        text-overflow: ellipsis
    }

    /* ---------- Tables / Cards ---------- */
    .card {
        border: 1px solid rgb(226 232 240);
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 1px 0 rgba(15, 23, 42, .03);
    }

    .card-h {
        padding: 14px 16px;
        border-bottom: 1px solid rgb(226 232 240);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        flex-wrap: wrap
    }

    .card-b {
        padding: 14px 16px
    }

    .kpi {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 10px
    }

    .kpi .k {
        border: 1px solid rgb(226 232 240);
        border-radius: 16px;
        padding: 12px;
        background: rgb(248 250 252)
    }

    .k .t {
        font-size: .78rem;
        color: rgb(100 116 139);
        font-weight: 800
    }

    .k .v {
        font-size: 1.2rem;
        font-weight: 900;
        color: rgb(15 23 42)
    }

    .table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0
    }

    .table th {
        font-size: .75rem;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: rgb(100 116 139);
        text-align: left;
        padding: 10px;
        border-bottom: 1px solid rgb(226 232 240)
    }

    .table td {
        padding: 10px;
        border-bottom: 1px solid rgb(241 245 249);
        vertical-align: top;
        color: rgb(15 23 42)
    }

    .table tr:hover td {
        background: rgb(248 250 252)
    }

    .input {
        width: 100%;
        border-radius: 14px;
        border: 1px solid rgb(226 232 240);
        padding: .6rem .8rem;
        font-weight: 650
    }

    .input:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(34, 211, 238, .35);
        border-color: rgb(34 211 238)
    }

    .help {
        font-size: .8rem;
        color: rgb(100 116 139)
    }

    .hr {
        height: 1px;
        background: rgb(226 232 240);
        margin: 12px 0
    }
</style>