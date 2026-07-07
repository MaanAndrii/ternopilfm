const stations = [
    {
        id: 'ternopil_fm',
        name: "Тернопіль 106,8 fm",
        streams: {
            sd: 'https://onair.lviv.fm:8443/ternopil.fm',
            hd: 'https://onair.lviv.fm:8443/ternopil.fm.hd'
        }
    },
    {
        id: 'lviv_fm',
        name: "Львів 100,8 fm",
        streams: {
            sd: 'https://onair.lviv.fm:8443/lviv.fm',
            hd: 'https://onair.lviv.fm:8443/lviv.fm.hd'
        }
    }
    // Сюди можна додавати інші станції
];

const playerConfig = {
    // Кількість станцій зі списку вище для відображення.
    // Якщо значення 0 або більше за кількість станцій, будуть показані всі.
    stations_to_display: 2,

    // ID станції, яка має відображатися за замовчуванням у режимі фрейму.
    iframe_station_id: 'ternopil_fm',

    initialVolume: 0.8,
    maxRetries: 5,
    retryDelay: 5000
};