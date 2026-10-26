(function(){
  const mapEl = document.getElementById('ourinhos-map');
  if (!mapEl || typeof L === 'undefined') return;

  const center = [-22.9795, -49.8705];
  const bounds = L.latLngBounds([[-23.035, -49.935], [-22.930, -49.820]]);
  const map = L.map(mapEl, {
    zoomControl: true,
    maxBounds: bounds,
    maxBoundsViscosity: .85,
    minZoom: 12,
    maxZoom: 16
  }).setView(center, 13);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors',
    maxZoom: 19
  }).addTo(map);

  /*
   * Mapa de calor: em vez de uma bolha por bairro, cada ocorrência cria
   * uma pequena nuvem de pontos ao redor do centro aproximado do bairro.
   * Isso produz uma mancha suave, semelhante a um heatmap geográfico,
   * sem criar círculos visíveis.
   */
  const heatLayer = (typeof L.heatLayer === 'function')
    ? L.heatLayer([], {
        radius: 38,
        blur: 42,
        maxZoom: 16,
        minOpacity: .08,
        max: 1,
        gradient: {
          0.00: '#2ea66b',
          0.20: '#59bd72',
          0.40: '#b8d84d',
          0.58: '#f3dc43',
          0.72: '#f4a52f',
          0.86: '#ef642e',
          1.00: '#d52f35'
        }
      }).addTo(map)
    : null;

  const labelLayer = L.layerGroup().addTo(map);
  const status = document.getElementById('map-status');
  const loading = document.getElementById('map-loading');
  let firstLoad = true;

  function levelLabel(count){
    if (count > 10) return 'Alta';
    if (count >= 6) return 'Média';
    return 'Baixa';
  }

  function labelClass(count){
    if (count > 10) return 'heat-number heat-number-red';
    if (count >= 6) return 'heat-number heat-number-orange';
    return 'heat-number heat-number-green';
  }

  // Gera uma nuvem radial de calor. O número de amostras e o peso crescem
  // com a quantidade de denúncias, mantendo 0 completamente invisível.
  function buildHeatCloud(region, count){
    const points = [];
    if (count <= 0) return points;

    const intensity = Math.min(count, 12) / 12;
    const samples = 22;
    const baseRadius = 0.0022 + intensity * 0.0018;

    // Centro mais forte.
    points.push([region.lat, region.lng, intensity]);

    // Anéis irregulares para evitar uma aparência circular artificial.
    for (let i = 0; i < samples; i++) {
      const angle = (Math.PI * 2 * i / samples) + ((i % 3) - 1) * 0.08;
      const ring = i % 2 === 0 ? 0.48 : 0.82;
      const jitterLat = Math.sin(i * 2.37) * 0.00035;
      const jitterLng = Math.cos(i * 1.71) * 0.00035;
      const lat = region.lat + Math.sin(angle) * baseRadius * ring + jitterLat;
      const lng = region.lng + Math.cos(angle) * baseRadius * ring + jitterLng;
      points.push([lat, lng, intensity * (0.42 + (i % 5) * 0.035)]);
    }

    // Uma camada mais larga e fraca deixa o calor "puxado" pela região,
    // em vez de parecer um marcador redondo.
    for (let i = 0; i < 10; i++) {
      const angle = Math.PI * 2 * i / 10 + 0.17;
      const lat = region.lat + Math.sin(angle) * baseRadius * 1.22;
      const lng = region.lng + Math.cos(angle) * baseRadius * 1.22;
      points.push([lat, lng, intensity * 0.16]);
    }

    return points;
  }

  async function refresh(){
    try {
      const response = await fetch('api/map_data.php?ts=' + Date.now(), { cache: 'no-store' });
      if (!response.ok) throw new Error('Falha ao carregar os dados');

      const data = await response.json();
      labelLayer.clearLayers();

      const points = [];
      data.regioes.forEach((region) => {
        const count = Number(region.count) || 0;

        // Zero ocorrências: não cria calor e não cria número.
        if (count <= 0) return;

        points.push(...buildHeatCloud(region, count));

        // Número limpo, sem círculo, caixa ou fundo.
        const icon = L.divIcon({
          className: 'heat-number-wrap',
          html: `<span class="${labelClass(count)}">${count}</span>`,
          iconSize: [34, 26],
          iconAnchor: [17, 13]
        });

        L.marker([region.lat, region.lng], {
          interactive: false,
          icon: icon,
          zIndexOffset: 1000
        }).addTo(labelLayer);

        // Área invisível apenas para abrir os detalhes ao clicar na região.
        const popup = L.popup({
          closeButton: true,
          className: 'heat-popup'
        }).setContent(
          `<div class="popup-title">${region.bairro}</div>` +
          `<div class="popup-count"><strong>${count}</strong> denúncia${count === 1 ? '' : 's'} registrada${count === 1 ? '' : 's'}<br>` +
          `Nível: ${levelLabel(count)}</div>`
        );

        L.circleMarker([region.lat, region.lng], {
          radius: 1,
          stroke: false,
          fillOpacity: 0,
          opacity: 0,
          interactive: true
        }).bindPopup(popup).addTo(labelLayer);
      });

      if (heatLayer) heatLayer.setLatLngs(points);

      status.textContent = `${data.total} denúncia${data.total === 1 ? '' : 's'} em Ourinhos · atualizado às ${data.atualizado}`;
      loading.classList.add('hidden');

      if (firstLoad) {
        map.fitBounds(bounds, {padding:[10,10]});
        map.setView(center, 13);
        firstLoad = false;
      }
    } catch (error) {
      status.textContent = 'Não foi possível atualizar o mapa agora.';
      loading.textContent = 'Erro ao carregar os dados';
    }
  }

  refresh();
  setInterval(refresh, 5000);
})();
