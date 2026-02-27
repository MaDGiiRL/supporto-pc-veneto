const quickLinks = [
    {
        label: 'Cartografie',
        hrefKey: 'cartografieUrl',
        className:
            'inline-flex items-center gap-2 rounded-xl border border-sky-200 bg-white px-4 py-2 text-sm font-medium text-sky-700 shadow-sm hover:shadow-md hover:bg-sky-50 transition',
        icon: MapIcon,
    },
    {
        label: 'Applicativi',
        hrefKey: 'applicativiUrl',
        className:
            'inline-flex items-center gap-2 rounded-xl bg-sky-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-700 transition',
        icon: DesktopIcon,
    },
];

const sections = [
    {
        title: 'Cartografie',
        hrefKey: 'cartografieUrl',
        imageKey: 'cartografieImg',
        description:
            'Mappe e layer tematici dei piani comunali di Protezione Civile e dataset elaborati dalla Direzione Protezione Civile e Polizia Locale.',
        gradient: 'from-sky-500 to-cyan-600',
        shadow: 'from-black/20',
        icon: MapIcon,
    },
    {
        title: 'Applicativi informatici',
        hrefKey: 'applicativiUrl',
        imageKey: 'applicativiImg',
        description:
            'Accesso a procedure per la gestione delle risorse umane e strumentali, riservato a utenti accreditati e volontari formati.',
        gradient: 'from-indigo-500 to-violet-600',
        shadow: 'from-black/25',
        icon: DesktopIcon,
    },
];

export function HomeApp({ content }) {
    return (
        <>
            <header className="relative overflow-hidden bg-gradient-to-b from-sky-50 via-white to-white">
                <div aria-hidden="true" className="pointer-events-none absolute -top-24 -left-24 h-80 w-80 rounded-full bg-sky-200/30 blur-3xl"></div>
                <div aria-hidden="true" className="pointer-events-none absolute -top-52 -right-20 h-96 w-96 rounded-full bg-cyan-200/30 blur-3xl"></div>

                <div className="container mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 lg:py-24">
                    <div className="mx-auto max-w-6xl grid lg:grid-cols-[1.1fr_0.9fr] gap-12 items-center">
                        <div>
                            <img src={content.regioneImg} alt="Regione del Veneto" className="w-36 sm:w-44 md:w-52 h-auto object-contain drop-shadow-sm" />

                            <h1 className="mt-8 text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight text-slate-900">
                                Portale di supporto alla{' '}
                                <span className="inline-block bg-gradient-to-r from-sky-700 to-cyan-600 bg-clip-text text-transparent">Protezione Civile del Veneto</span>
                            </h1>

                            <p className="mt-4 text-base sm:text-lg text-slate-600 max-w-2xl">
                                Strumenti operativi e risorse digitali per gli operatori del Sistema Regionale di Protezione Civile.
                            </p>

                            <div className="mt-6 flex flex-wrap items-center gap-3">
                                {quickLinks.map((link) => (
                                    <a key={link.label} href={content[link.hrefKey]} className={link.className}>
                                        <link.icon className="h-5 w-5" />
                                        {link.label}
                                    </a>
                                ))}
                            </div>

                            <p className="mt-6 text-xs sm:text-sm text-slate-500 max-w-3xl">
                                I dati non sostituiscono quelli ufficiali né i piani comunali approvati, ma costituiscono uno strumento di supporto per gli Enti del sistema regionale.
                            </p>
                        </div>

                        <div className="relative">
                            <div className="rounded-3xl border border-slate-200 bg-white/70 backdrop-blur p-3 shadow-sm">
                                <div className="aspect-[3/3] w-full overflow-hidden rounded-2xl ring-1 ring-slate-200">
                                    <img src={content.headerImg} alt="Panoramica" className="h-full w-full object-cover object-center" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main className="container mx-auto px-4 sm:px-6 lg:px-8 pb-20 mt-10">
                <div className="mx-auto max-w-7xl grid gap-10 md:grid-cols-2 lg:gap-12">
                    {sections.map((section) => (
                        <a
                            key={section.title}
                            href={content[section.hrefKey]}
                            className={`group relative overflow-hidden rounded-3xl bg-gradient-to-br ${section.gradient} shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5 min-h-[340px]`}
                        >
                            <div className="absolute inset-0 opacity-20">
                                <img src={content[section.imageKey]} alt={section.title} className="w-full h-full object-cover object-center" />
                                <div className={`absolute inset-0 bg-gradient-to-t ${section.shadow} via-transparent to-transparent`}></div>
                            </div>

                            <div className="relative z-10 p-8 flex flex-col justify-between h-full">
                                <div className="flex items-center gap-3 mb-4">
                                    <div className="rounded-xl bg-white/20 border border-white/25 p-3">
                                        <section.icon className="h-6 w-6 text-white" />
                                    </div>
                                    <h2 className="text-white text-2xl font-bold leading-tight">{section.title}</h2>
                                </div>

                                <p className="text-white/90 text-sm leading-relaxed mb-6">{section.description}</p>

                                <div className="inline-flex items-center gap-2 rounded-lg bg-white/20 px-3 py-1.5 text-sm font-medium text-white group-hover:bg-white/25 transition self-start">
                                    Vai alla sezione <ChevronRightIcon className="h-4 w-4" />
                                </div>
                            </div>
                        </a>
                    ))}
                </div>

                <section id="assistenza" className="max-w-7xl mx-auto mt-14 sm:mt-16">
                    <div className="relative overflow-hidden rounded-3xl border border-slate-200 bg-white/80 backdrop-blur px-6 py-6 sm:px-8 sm:py-8 shadow-sm">
                        <div className="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                            <div className="flex items-center gap-3">
                                <span className="inline-grid place-items-center rounded-xl bg-sky-50 border border-sky-200 p-2">
                                    <LifebuoyIcon className="h-6 w-6 text-sky-700" />
                                </span>
                                <h3 className="text-base font-semibold text-slate-800">Assistenza e supporto</h3>
                            </div>
                            <p className="text-sm text-slate-600 flex-1 pt-3">
                                Hai bisogno di aiuto o non riesci ad accedere agli applicativi? Contatta il referente di Protezione Civile della tua struttura.
                            </p>
                        </div>
                    </div>
                </section>
            </main>
        </>
    );
}

function iconBase({ className, children, viewBox = '0 0 24 24' }) {
    return (
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox={viewBox} strokeWidth="1.5" stroke="currentColor" className={className}>
            {children}
        </svg>
    );
}

function MapIcon({ className }) {
    return iconBase({
        className,
        children: (
            <path strokeLinecap="round" strokeLinejoin="round" d="M9 6.75V15m6-6v8.25m-10.25 2.5 4.5-2.25 6 2.25 4.5-2.25V4.79l-4.5 2.25-6-2.25-4.5 2.25v12.71Z" />
        ),
    });
}

function DesktopIcon({ className }) {
    return iconBase({
        className,
        children: (
            <>
                <path strokeLinecap="round" strokeLinejoin="round" d="M3.75 5.25h16.5a.75.75 0 0 1 .75.75v9a.75.75 0 0 1-.75.75H3.75A.75.75 0 0 1 3 15V6a.75.75 0 0 1 .75-.75Z" />
                <path strokeLinecap="round" strokeLinejoin="round" d="M9 18.75h6m-7.5 0h9" />
            </>
        ),
    });
}

function ChevronRightIcon({ className }) {
    return iconBase({
        className,
        children: <path strokeLinecap="round" strokeLinejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />,
    });
}

function LifebuoyIcon({ className }) {
    return iconBase({
        className,
        children: (
            <>
                <path strokeLinecap="round" strokeLinejoin="round" d="M12 3.75a8.25 8.25 0 1 0 8.25 8.25A8.25 8.25 0 0 0 12 3.75Z" />
                <path strokeLinecap="round" strokeLinejoin="round" d="M7.5 7.5 9.75 9.75m4.5 4.5 2.25 2.25m0-9-2.25 2.25m-4.5 4.5L7.5 16.5" />
            </>
        ),
    });
}
