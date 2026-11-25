/* ============================================================
   GlicoSys - Camada de dados
   JavaScript puro (sem frameworks/bibliotecas), usando localStorage
   ============================================================ */

var CHAVE_USUARIOS = 'glicosys_usuarios';
var CHAVE_SESSAO = 'glicosys_sessao';

/* Tabela de referência de Índice Glicêmico (IG) dos alimentos.
   porcao/unidade = porção de referência usada para os carboidratos informados. */
var ALIMENTOS = [
  { id: '1',        nome: 'Feijão preto cozido',    porcao: 150, unidade: 'g',  carboidratos: 24, ig: 30 },
  { id: '2',             nome: 'Lentilha cozida',        porcao: 150, unidade: 'g',  carboidratos: 30, ig: 32 },
  { id: '3',       nome: 'Leite integral',         porcao: 250, unidade: 'ml', carboidratos: 12, ig: 31 },
  { id: '4',              nome: 'Iogurte natural',        porcao: 200, unidade: 'g',  carboidratos: 9,  ig: 36 },
  { id: '5',                 nome: 'Maçã',                   porcao: 120, unidade: 'g',  carboidratos: 16, ig: 36 },
  { id: '6',              nome: 'Laranja',                porcao: 130, unidade: 'g',  carboidratos: 15, ig: 40 },
  { id: '7',              nome: 'Morango',                porcao: 120, unidade: 'g',  carboidratos: 8,  ig: 41 },
  { id: '8',                  nome: 'Uva',                    porcao: 120, unidade: 'g',  carboidratos: 18, ig: 59 },
  { id: '9',                nome: 'Mamão',                  porcao: 150, unidade: 'g',  carboidratos: 13, ig: 60 },
  { id: '10',                  nome: 'Mel',                    porcao: 25,  unidade: 'g',  carboidratos: 21, ig: 61 },
  { id: '11',               nome: 'Banana madura',          porcao: 120, unidade: 'g',  carboidratos: 28, ig: 62 },
  { id: '12',         nome: 'Arroz branco cozido',    porcao: 150, unidade: 'g',  carboidratos: 42, ig: 64 },
  { id: '13',            nome: 'Beterraba cozida',       porcao: 80,  unidade: 'g',  carboidratos: 7,  ig: 64 },
  { id: '14',            nome: 'Pão de forma branco',    porcao: 30,  unidade: 'g',  carboidratos: 14, ig: 65 },
  { id: '15',              nome: 'Tapioca',                porcao: 100, unidade: 'g',  carboidratos: 34, ig: 70 },
  { id: '16',             nome: 'Melancia',               porcao: 150, unidade: 'g',  carboidratos: 11, ig: 72 },
  { id: '17',          nome: 'Pão francês',            porcao: 50,  unidade: 'g',  carboidratos: 29, ig: 73 },
  { id: '18',           nome: 'Pão de queijo',          porcao: 60,  unidade: 'g',  carboidratos: 26, ig: 74 },
  { id: '19',               nome: 'Batata cozida',          porcao: 150, unidade: 'g',  carboidratos: 26, ig: 78 },
  { id: '20',    nome: 'Arroz branco inst.',     porcao: 150, unidade: 'g',  carboidratos: 45, ig: 87 },
  { id: '21',         nome: 'Refrigerante (cola)',    porcao: 350, unidade: 'ml', carboidratos: 37, ig: 90 }
];

var Store = {

  /* ---------- utilidades ---------- */
  gerarId: function () {
    return Date.now().toString(36) + Math.random().toString(36).slice(2, 7);
  },
  lerJSON: function (chave, padrao) {
    try {
      var bruto = localStorage.getItem(chave);
      return bruto ? JSON.parse(bruto) : padrao;
    } catch (erro) {
      return padrao;
    }
  },
  gravarJSON: function (chave, valor) {
    localStorage.setItem(chave, JSON.stringify(valor));
  },

  /* ---------- usuários / sessão ---------- */
  obterUsuarios: function () {
    return this.lerJSON(CHAVE_USUARIOS, []);
  },
  salvarUsuarios: function (lista) {
    this.gravarJSON(CHAVE_USUARIOS, lista);
  },
  obterUsuarioPorEmail: function (email) {
    email = (email || '').toLowerCase();
    return this.obterUsuarios().filter(function (u) { return u.email.toLowerCase() === email; })[0] || null;
  },
  criarSessao: function (usuarioId) {
    this.gravarJSON(CHAVE_SESSAO, { usuarioId: usuarioId });
  },
  obterSessao: function () {
    return this.lerJSON(CHAVE_SESSAO, null);
  },
  encerrarSessao: function () {
    localStorage.removeItem(CHAVE_SESSAO);
  },
  obterUsuarioAtual: function () {
    var sessao = this.obterSessao();
    if (!sessao) return null;
    var usuarios = this.obterUsuarios();
    for (var i = 0; i < usuarios.length; i++) {
      if (usuarios[i].id === sessao.usuarioId) return usuarios[i];
    }
    return null;
  },

  /* ---------- dados por usuário ---------- */
  chaveGlicemia: function (usuarioId) { return 'glicosys_glicemia_' + usuarioId; },
  chaveRefeicoes: function (usuarioId) { return 'glicosys_refeicoes_' + usuarioId; },
  chavePerfil: function (usuarioId) { return 'glicosys_perfil_' + usuarioId; },

  obterPerfil: function (usuarioId) {
    return this.lerJSON(this.chavePerfil(usuarioId), { metaMin: 70, metaMax: 140 });
  },
  salvarPerfil: function (usuarioId, perfil) {
    this.gravarJSON(this.chavePerfil(usuarioId), perfil);
  },

  obterGlicemias: function (usuarioId) {
    return this.lerJSON(this.chaveGlicemia(usuarioId), []);
  },
  salvarGlicemias: function (usuarioId, lista) {
    this.gravarJSON(this.chaveGlicemia(usuarioId), lista);
  },

  obterRefeicoes: function (usuarioId) {
    return this.lerJSON(this.chaveRefeicoes(usuarioId), []);
  },
  salvarRefeicoes: function (usuarioId, lista) {
    this.gravarJSON(this.chaveRefeicoes(usuarioId), lista);
  },

  /* ---------- alimentos ---------- */
  obterAlimentos: function () {
    return ALIMENTOS;
  },
  obterAlimentoPorId: function (id) {
    for (var i = 0; i < ALIMENTOS.length; i++) {
      if (ALIMENTOS[i].id === id) return ALIMENTOS[i];
    }
    return null;
  },

  /* ---------- cálculos ---------- */
  categoriaIG: function (ig) {
    if (ig <= 55) return 'baixo';
    if (ig <= 69) return 'medio';
    return 'alto';
  },
  cgPorcao: function (alimento) {
    return Math.round((alimento.ig * alimento.carboidratos) / 100);
  },
  carboidratosAjustados: function (alimento, quantidade) {
    return (alimento.carboidratos * quantidade) / alimento.porcao;
  },
  cgItem: function (alimento, quantidade) {
    var carb = this.carboidratosAjustados(alimento, quantidade);
    return Math.round((alimento.ig * carb) / 100);
  },
  calcularCGRefeicao: function (refeicao) {
    var total = 0;
    var self = this;
    (refeicao.itens || []).forEach(function (item) {
      var alimento = self.obterAlimentoPorId(item.alimentoId);
      if (alimento) total += self.cgItem(alimento, Number(item.quantidade));
    });
    return total;
  },
  classificarCG: function (cg) {
    if (cg <= 10) return { rotulo: 'CG baixa', classe: 'badge-verde', chave: 'baixa' };
    if (cg <= 19) return { rotulo: 'CG moderada', classe: 'badge-laranja', chave: 'moderada' };
    return { rotulo: 'CG alta', classe: 'badge-vermelho', chave: 'alta' };
  },
  classificarGlicemia: function (valor, perfil) {
    if (valor < perfil.metaMin) return { rotulo: 'Baixa', classe: 'badge-vermelho' };
    if (valor <= perfil.metaMax) return { rotulo: 'No alvo', classe: 'badge-verde' };
    if (valor <= perfil.metaMax + 40) return { rotulo: 'Elevada', classe: 'badge-laranja' };
    return { rotulo: 'Alta', classe: 'badge-vermelho' };
  },

  /* ---------- formatação ---------- */
  formatarDataBR: function (isoData) {
    if (!isoData) return '—';
    var partes = isoData.split('-');
    return partes[2] + '/' + partes[1] + '/' + partes[0];
  },
  rotuloContexto: function (contexto) {
    var mapa = {
      'jejum': 'Jejum',
      'pre-prandial': 'Pré-Prandial',
      'pos-prandial': 'Pós-Prandial',
      'antes-dormir': 'Antes de dormir'
    };
    return mapa[contexto] || contexto || '';
  },
  compararDataHoraDesc: function (a, b) {
    var chaveA = a.data + 'T' + (a.hora || '00:00');
    var chaveB = b.data + 'T' + (b.hora || '00:00');
    if (chaveA < chaveB) return 1;
    if (chaveA > chaveB) return -1;
    return 0;
  },
  compararDataHoraAsc: function (a, b) {
    return -this.compararDataHoraDesc(a, b);
  },

  /* ---------- seed de demonstração (nova conta) ---------- */
  semear: function (usuarioId) {
    var g = this.gerarId.bind(this);
    var glicemias = [
      { id: g(), data: '2026-08-01', hora: '07:30', valor: 96,  contexto: 'jejum',        refeicaoId: '', observacao: '' },
      { id: g(), data: '2026-07-31', hora: '07:45', valor: 112, contexto: 'jejum',        refeicaoId: '', observacao: 'Estresse no trabalho' },
      { id: g(), data: '2026-07-30', hora: '07:20', valor: 98,  contexto: 'jejum',        refeicaoId: '', observacao: '' },
      { id: g(), data: '2026-07-29', hora: '13:00', valor: 158, contexto: 'pos-prandial', refeicaoId: '', observacao: '' },
      { id: g(), data: '2026-07-29', hora: '07:30', valor: 102, contexto: 'jejum',        refeicaoId: '', observacao: '' }
    ];
    var refeicoes = [
      {
        id: g(), nome: 'Café da manhã', data: '2026-08-02', hora: '08:00',
        itens: [{ alimentoId: 'iogurte', quantidade: 200 }, { alimentoId: 'morango', quantidade: 120 }],
        descricao: 'Iogurte natural, Morango', observacao: ''
      },
      {
        id: g(), nome: 'Almoço', data: '2026-08-01', hora: '12:30',
        itens: [{ alimentoId: 'arroz-branco', quantidade: 80 }, { alimentoId: 'feijao-preto', quantidade: 60 }],
        descricao: 'Arroz branco cozido, Feijão preto cozido', observacao: ''
      },
      {
        id: g(), nome: 'Café da manhã', data: '2026-08-01', hora: '07:30',
        itens: [{ alimentoId: 'pao-frances', quantidade: 50 }, { alimentoId: 'leite-integral', quantidade: 100 }],
        descricao: 'Pão francês, Leite integral', observacao: ''
      }
    ];
    this.salvarGlicemias(usuarioId, glicemias);
    this.salvarRefeicoes(usuarioId, refeicoes);
  }
};
