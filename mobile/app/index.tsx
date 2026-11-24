import React from 'react';
import {
  ScrollView, View, Text, ImageBackground, Image,
  StyleSheet, Pressable, Dimensions
} from 'react-native';
import { StatusBar } from 'expo-status-bar';

const { width } = Dimensions.get('window');

const colors = {
  night: '#171313',
  paper: '#F1EEE8',
  red: '#D92736',
  muted: '#A9A29A',
};

const curiosities = [
  {
    title: 'Música',
    text: 'Mozart, Haydn e Schubert ajudam a associar a Áustria à música clássica.',
    image: require('../assets/musica-austria.jpg'),
  },
  {
    title: 'Cidades',
    text: 'Viena reúne palácios, museus e edifícios históricos.',
    image: require('../assets/palacio.jpg'),
  },
  {
    title: 'Tradições',
    text: 'Do Krampus aos Perchten, o inverno alpino tem festas marcantes.',
    image: require('../assets/images.jpg'),
  },
];

const history = [
  ['976', 'A região aparece como a Marca Oriental, ligada ao Sacro Império Romano-Germânico.'],
  ['1278', 'A dinastia dos Habsburgo começa a governar os territórios austríacos.'],
  ['1804', 'É proclamado o Império Austríaco.'],
  ['1867', 'Forma-se a Monarquia Austro-Húngara.'],
  ['1918', 'Com o fim da Primeira Guerra, nasce a República da Áustria.'],
  ['1955', 'A Áustria recupera sua independência e declara neutralidade permanente.'],
  ['1995', 'A Áustria entra na União Europeia.'],
];

function Eyebrow({ children }: { children: string }) {
  return <Text style={styles.eyebrow}>{children}</Text>;
}

function SectionTitle({ children }: { children: string }) {
  return <Text style={styles.sectionTitle}>{children}</Text>;
}

export default function HomeScreen() {
  const [selectedYear, setSelectedYear] = React.useState(0);

  return (
    <ScrollView style={styles.page} contentContainerStyle={styles.content}>
      <StatusBar style="light" />

      <ImageBackground
        source={require('../assets/cidades-austria.jpg')}
        style={styles.hero}
        imageStyle={styles.heroImage}
      >
        <View style={styles.heroOverlay} />
        <View style={styles.heroContent}>
          <Eyebrow>EUROPA CENTRAL · DESDE 976</Eyebrow>
          <Text style={styles.heroTitle}>DESCUBRA{'\n'}<Text style={{ color: '#FFFFFFB8' }}>A ÁUSTRIA.</Text></Text>
          <Text style={styles.heroDescription}>
            Entre montanhas, palácios e lendas: uma viagem pela cultura e pela história de um país fascinante.
          </Text>
          <Pressable onPress={() => {}} style={styles.heroButton}>
            <Text style={styles.heroButtonText}>EXPLORE O PAÍS ↓</Text>
          </Pressable>
        </View>
      </ImageBackground>

      <View style={styles.section}>
        <Eyebrow>01 — IDENTIDADE</Eyebrow>
        <SectionTitle>MUITO ALÉM{'\n'}DA PAISAGEM.</SectionTitle>
        <Text style={styles.lead}>
          A Áustria reúne símbolos, tradições e expressões culturais que atravessaram séculos e continuam presentes no cotidiano do país.
        </Text>

        <View style={styles.facts}>
          {[
            ['01', 'BANDEIRA', 'Três faixas horizontais: vermelha, branca e vermelha.'],
            ['02', 'CORES', 'Vermelho e branco da bandeira; verde, azul e tons terrosos lembram os Alpes e os lagos.'],
            ['03', 'ÁGUIA FEDERAL', 'Símbolo do brasão da Áustria, representa a república e a soberania do país.'],
            ['04', 'ALPES', 'Ocupam boa parte do território e marcam a paisagem austríaca.'],
            ['05', 'MÚSICA CLÁSSICA', 'Mozart, Haydn e Schubert são nomes ligados à tradição musical austríaca.'],
            ['06', 'ARQUITETURA', 'Palácios, edifícios barrocos e construções históricas, especialmente em Viena.'],
            ['07', 'CAFÉS VIENENSES', 'Lugares de encontro, leitura e conversa, parte da vida cultural da capital.'],
          ].map(([n, title, desc]) => (
            <View key={n} style={styles.factRow}>
              <Text style={styles.factNumber}>{n}</Text>
              <View style={{ flex: 1 }}>
                <Text style={styles.factTitle}>{title}</Text>
                <Text style={styles.factText}>{desc}</Text>
              </View>
            </View>
          ))}
        </View>
      </View>

      <View style={[styles.section, styles.darkSection]}>
        <Eyebrow>02 — FOLCLORE</Eyebrow>
        <SectionTitle>HISTÓRIAS QUE{'\n'}NÃO SE ESQUECEM.</SectionTitle>
        <Text style={styles.darkLead}>
          Criaturas misteriosas, aparições e personagens que fazem parte do imaginário popular austríaco.
        </Text>

        <View style={styles.legendCard}>
          <Image source={require('../assets/krampus.png')} style={styles.cardImage} />
          <View style={styles.cardBody}>
            <Text style={styles.cardTag}>CRIATURA FOLCLÓRICA</Text>
            <Text style={styles.cardTitle}>KRAMPUS</Text>
            <Text style={styles.cardText}>
              Criatura lendária do folclore alpino que acompanha São Nicolau nas tradições de dezembro.
            </Text>
          </View>
        </View>
        <View style={styles.legendCard}>
          <Image source={require('../assets/damabranca.jpg')} style={styles.cardImage} />
          <View style={styles.cardBody}>
            <Text style={styles.cardTag}>LENDA MISTERIOSA</Text>
            <Text style={styles.cardTitle}>A DAMA BRANCA</Text>
            <Text style={styles.cardText}>
              Figura de histórias sobre castelos, antigas famílias nobres e aparições misteriosas.
            </Text>
          </View>
        </View>
        <View style={styles.legendCard}>
          <Image source={require('../assets/bichofeio.jpg')} style={styles.cardImage} />
          <View style={styles.cardBody}>
            <Text style={styles.cardTag}>TRADIÇÃO ALPINA</Text>
            <Text style={styles.cardTitle}>PERCHTEN</Text>
            <Text style={styles.cardText}>
              Personagens mascarados das tradições de inverno dos Alpes.
            </Text>
          </View>
        </View>
      </View>

      <View style={styles.section}>
        <Eyebrow>03 — LINHA DO TEMPO</Eyebrow>
        <SectionTitle>SÉCULOS EM{'\n'}MOVIMENTO.</SectionTitle>
        <Text style={styles.lead}>Toque em uma data para conhecer um acontecimento da história austríaca.</Text>
        <ScrollView horizontal showsHorizontalScrollIndicator={false} contentContainerStyle={styles.yearList}>
          {history.map(([year], index) => (
            <Pressable
              key={year}
              onPress={() => setSelectedYear(index)}
              style={[styles.yearButton, selectedYear === index && styles.yearButtonActive]}
            >
              <Text style={[styles.yearText, selectedYear === index && styles.yearTextActive]}>{year}</Text>
            </Pressable>
          ))}
        </ScrollView>
        <View style={styles.historyCard}>
          <Text style={styles.historyYear}>{history[selectedYear][0]}</Text>
          <Text style={styles.historyText}>{history[selectedYear][1]}</Text>
        </View>
      </View>

      <ImageBackground
        source={require('../assets/palacio.jpg')}
        style={styles.vienna}
        imageStyle={{ opacity: 0.45 }}
      >
        <Eyebrow>04 — A CAPITAL</Eyebrow>
        <SectionTitle>VIENA ATRAVÉS{'\n'}DO TEMPO.</SectionTitle>
        <Text style={styles.darkLead}>
          De um acampamento romano a uma das capitais culturais mais conhecidas da Europa.
        </Text>
        <Text style={styles.viennaNote}>
          A cidade reúne edifícios históricos, museus, espaços culturais e uma vida urbana reconhecida internacionalmente.
        </Text>
      </ImageBackground>

      <View style={styles.section}>
        <Eyebrow>05 — PARA DESCOBRIR</Eyebrow>
        <SectionTitle>PEQUENOS{'\n'}GRANDES FATOS.</SectionTitle>
        <Text style={styles.lead}>Detalhes que revelam um pouco mais da personalidade austríaca.</Text>

        {curiosities.map((item) => (
          <View key={item.title} style={styles.curiosityCard}>
            <Image source={item.image} style={styles.curiosityImage} />
            <View style={styles.curiosityBody}>
              <Text style={styles.curiosityTitle}>{item.title}</Text>
              <Text style={styles.curiosityText}>{item.text}</Text>
            </View>
          </View>
        ))}
      </View>

      <View style={styles.footer}>
        <Text style={styles.footerBrand}>ÁUSTRIA.</Text>
        <Text style={styles.footerText}>Uma viagem pela cultura, história e paisagens da Europa Central.</Text>
        <Text style={styles.footerSmall}>PROJETO ESCOLAR · 2026</Text>
      </View>
    </ScrollView>
  );
}

const styles = StyleSheet.create({
  page: { flex: 1, backgroundColor: colors.night },
  content: { paddingBottom: 0 },
  hero: { minHeight: 640, justifyContent: 'flex-end', paddingHorizontal: 24, paddingVertical: 70, backgroundColor: colors.night },
  heroImage: { resizeMode: 'cover' },
  heroOverlay: { ...StyleSheet.absoluteFillObject, backgroundColor: 'rgba(15,12,12,0.55)' },
  heroContent: { maxWidth: 600 },
  eyebrow: { color: colors.red, fontSize: 10, fontWeight: '800', letterSpacing: 3, marginBottom: 18 },
  heroTitle: { color: '#fff', fontSize: Math.min(width * 0.14, 68), lineHeight: Math.min(width * 0.145, 72), fontWeight: '900', letterSpacing: -3 },
  heroDescription: { color: '#FFFFFFD0', fontSize: 16, lineHeight: 25, marginTop: 24, maxWidth: 360, fontStyle: 'italic' },
  heroButton: { borderWidth: 1, borderColor: '#FFFFFF99', paddingVertical: 15, paddingHorizontal: 18, alignSelf: 'flex-start', marginTop: 28 },
  heroButtonText: { color: '#fff', fontSize: 10, fontWeight: '800', letterSpacing: 2 },
  section: { backgroundColor: colors.paper, paddingHorizontal: 24, paddingVertical: 64 },
  sectionTitle: { color: colors.night, fontSize: 42, lineHeight: 42, fontWeight: '900', letterSpacing: -2, marginBottom: 20 },
  lead: { color: '#625B56', fontSize: 17, lineHeight: 26, fontStyle: 'italic', marginBottom: 28 },
  facts: { borderTopWidth: 1, borderTopColor: '#CFC8C0' },
  factRow: { flexDirection: 'row', gap: 16, paddingVertical: 18, borderBottomWidth: 1, borderBottomColor: '#CFC8C0' },
  factNumber: { color: colors.red, fontSize: 10, fontWeight: '800', paddingTop: 2 },
  factTitle: { color: colors.night, fontSize: 13, fontWeight: '900', letterSpacing: 1, marginBottom: 7 },
  factText: { color: '#625B56', fontSize: 13, lineHeight: 20 },
  darkSection: { backgroundColor: '#21191A' },
  darkLead: { color: '#FFFFFFB8', fontSize: 17, lineHeight: 26, fontStyle: 'italic', marginBottom: 28 },
  legendCard: { borderWidth: 1, borderColor: '#FFFFFF25', marginBottom: 14 },
  cardImage: { width: '100%', height: 190, resizeMode: 'cover' },
  cardBody: { padding: 20 },
  cardTag: { color: '#F0787F', fontSize: 9, fontWeight: '800', letterSpacing: 2 },
  cardTitle: { color: '#fff', fontSize: 25, fontWeight: '900', marginTop: 12 },
  cardText: { color: '#FFFFFFB8', fontSize: 14, lineHeight: 22, marginTop: 8 },
  yearList: { gap: 8, paddingVertical: 12 },
  yearButton: { borderWidth: 1, borderColor: '#CFC8C0', paddingHorizontal: 18, paddingVertical: 14 },
  yearButtonActive: { backgroundColor: colors.red, borderColor: colors.red },
  yearText: { color: colors.night, fontWeight: '900', fontSize: 16 },
  yearTextActive: { color: '#fff' },
  historyCard: { borderTopWidth: 1, borderBottomWidth: 1, borderColor: '#CFC8C0', paddingVertical: 28 },
  historyYear: { color: colors.red, fontSize: 48, fontWeight: '900', letterSpacing: -2 },
  historyText: { color: '#625B56', fontSize: 17, lineHeight: 27, marginTop: 12 },
  vienna: { paddingHorizontal: 24, paddingVertical: 70, backgroundColor: '#21191A', minHeight: 450, justifyContent: 'center' },
  viennaNote: { color: '#FFFFFFD0', fontSize: 16, lineHeight: 26, marginTop: 30, borderLeftWidth: 2, borderLeftColor: colors.red, paddingLeft: 16 },
  curiosityCard: { marginBottom: 16, backgroundColor: '#21191A' },
  curiosityImage: { width: '100%', height: 210, resizeMode: 'cover' },
  curiosityBody: { padding: 20 },
  curiosityTitle: { color: '#fff', fontSize: 25, fontWeight: '900', textTransform: 'uppercase' },
  curiosityText: { color: '#FFFFFFB8', fontSize: 14, lineHeight: 22, marginTop: 8 },
  footer: { backgroundColor: colors.night, paddingHorizontal: 24, paddingVertical: 42 },
  footerBrand: { color: '#fff', fontSize: 24, fontWeight: '900', letterSpacing: 4 },
  footerText: { color: '#FFFFFF99', fontSize: 13, lineHeight: 20, marginTop: 12, maxWidth: 300 },
  footerSmall: { color: colors.red, fontSize: 9, fontWeight: '800', letterSpacing: 2, marginTop: 28 },
});
