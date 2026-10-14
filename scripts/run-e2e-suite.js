const http = require('http');
const crypto = require('crypto');

function post(path, headers, body) {
  return new Promise((resolve, reject) => {
    const data = JSON.stringify(body);
    const req = http.request({
      hostname: '127.0.0.1',
      port: 8890,
      path: path,
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Content-Length': Buffer.byteLength(data),
        ...headers
      }
    }, res => {
      let buf = '';
      res.on('data', d => buf += d);
      res.on('end', () => resolve({ status: res.statusCode, data: JSON.parse(buf || '{}') }));
    });
    req.on('error', reject);
    req.write(data);
    req.end();
  });
}

function get(path) {
  return new Promise((resolve, reject) => {
    const req = http.request({
      hostname: '127.0.0.1',
      port: 8890,
      path: path,
      method: 'GET'
    }, res => {
      let buf = '';
      res.on('data', d => buf += d);
      res.on('end', () => resolve({ status: res.statusCode, headers: res.headers, body: buf }));
    });
    req.on('error', reject);
    req.end();
  });
}

async function run() {
  console.log('--- 1. Testing Citizen Claim Ingestion ---');
  const claimRes = await post('/wp-json/falso/v1/claims/submit', {}, {
    claim_text: '????? ?????? ???? ??? ??????? ?????? ?? ??????? ??????',
    source_url: 'https://facebook.com/libya-water-rumor',
    region: '??????'
  });
  console.log('Claim Status:', claimRes.status, 'Response:', JSON.stringify(claimRes.data));

  console.log('\n--- 2. Testing 301 Historical Preservation Redirect ---');
  const redirectRes = await get('/archives/1092');
  console.log('Redirect Status:', redirectRes.status, 'Location Header:', redirectRes.headers.location);

  console.log('\n--- 3. Testing Make.com HMAC Webhook Authentication ---');
  const secret = 'falso_super_secret_signing_key_2026';
  const aiPayload = {
    claim_id: 101,
    hate_speech_score: 0.88,
    sentiment: 'negative',
    extracted_entities: ['???? ????? ???????', '??????']
  };
  const bodyStr = JSON.stringify(aiPayload);
  const signature = crypto.createHmac('sha256', secret).update(bodyStr).digest('hex');

  const aiRes = await post('/wp-json/falso/v1/integrations/ai-analysis', { 'X-Falso-Signature': signature }, aiPayload);
  console.log('AI Webhook Status:', aiRes.status, 'Response:', JSON.stringify(aiRes.data));

  console.log('\n--- 4. Testing Forged Webhook Rejection (Security Invariant) ---');
  const forgedRes = await post('/wp-json/falso/v1/integrations/ai-analysis', { 'X-Falso-Signature': 'forged_fake_sig' }, aiPayload);
  console.log('Forged Status:', forgedRes.status, 'Response:', JSON.stringify(forgedRes.data));

  console.log('\n--- 5. Validating Live ClaimReview Schema ---');
  const pageRes = await get('/investigations/mitiga-airport-claim');
  const match = pageRes.body.match(/<script type="application\/ld\+json">(.*?)<\/script>/s);
  if (match) {
    const parsedSchema = JSON.parse(match[1]);
    console.log('Schema Type:', parsedSchema['@type']);
    console.log('Claim Reviewed:', parsedSchema.claimReviewed);
    console.log('Verdict Rating:', parsedSchema.reviewRating.alternateName, 'Value:', parsedSchema.reviewRating.ratingValue);
  }
}

run().catch(console.error);
