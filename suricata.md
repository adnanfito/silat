## **1. PENGENALAN SURICATA RULES**

Suricata adalah **IDS/IPS (Intrusion Detection/Prevention System)** yang lebih modern dari Snort.

**Kesamaan dengan Snort:**
- Format rule hampir sama
- Menggunakan pattern matching
- Syntax serupa

**Perbedaan Suricata:**
- Support multi-threading (lebih cepat)
- Better HTTP inspection
- Support more protocols
- Output ke JSON (eve.json)

---

## **2. STRUKTUR DASAR SURICATA RULE**

```
alert http $HOME_NET any -> $EXTERNAL_NET any (msg:"Description"; content:"pattern"; sid:123456; rev:1;)
```

**Breakdown:**

| Komponen | Fungsi | Contoh |
|----------|--------|--------|
| `alert` | Action | alert, drop, pass, reject |
| `http` | Protocol | http, tcp, udp, icmp, dns, tls |
| `$HOME_NET` | Source IP | Internal network |
| `any` | Source Port | Any port |
| `->` | Direction | Unidirectional |
| `$EXTERNAL_NET` | Destination IP | External network |
| `any` | Destination Port | Any port |
| `(...)` | Options | Pattern & metadata |

---

## **3.  ACTION (alert, drop, pass, reject)**

### **alert**
```
alert http $HOME_NET any -> $EXTERNAL_NET any (...)
```
- **Generate alert** + log traffic
- Detect tanpa blocking
- Paling umum untuk monitoring

---

### **drop**
```
drop http $HOME_NET any -> $EXTERNAL_NET any (...)
```
- **Block traffic** + generate alert
- Proactive defense
- Ngegabung TCP streams, lalu drop

---

### **pass**
```
pass http $HOME_NET any -> $EXTERNAL_NET any (...)
```
- **Allow traffic** + log
- Whitelist certain traffic
- Useful untuk exclude legitimate traffic

---

### **reject**
```
reject http $HOME_NET any -> $EXTERNAL_NET any (...)
```
- **Block traffic** + send RST packet
- Force connection close
- More aggressive than drop

---

## **4.  PROTOCOL**

### **Protokol yang didukung Suricata:**

```
http       = HTTP traffic (layer 7)
tcp        = TCP traffic (layer 4)
udp        = UDP traffic (layer 4)
icmp       = ICMP (ping, traceroute)
dns        = DNS queries
tls        = TLS/SSL encrypted traffic
ip         = Any IP traffic
```

---

### **HTTP - Layer 7 Analysis**

```
alert http $HOME_NET any -> $EXTERNAL_NET any (...)
```

**Keunggulan HTTP protocol:**
- Deep inspection HTTP requests/responses
- Can parse headers, body, URI
- Best untuk web app attacks (SQLi, XSS, dll)
- Can decode encodings (gzip, chunked, dll)

---

### **TCP - Layer 4 Analysis**

```
alert tcp $HOME_NET any -> $EXTERNAL_NET any (...)
```

**Fungsi:**
- Monitor TCP connections
- Lebih generic daripada HTTP
- Bisa catch non-HTTP traffic
- Less granular inspection

---

### **DNS Protocol**

```
alert dns $HOME_NET any -> $EXTERNAL_NET any (...)
```

**Fungsi:**
- Monitor DNS queries
- Detect malicious domain queries
- Detect DNS tunneling
- C2 communication detection

---

## **5. VARIABLES & ADDRESSES**

### **Built-in Variables:**

```
$HOME_NET       = Internal network (defined in config)
$EXTERNAL_NET   = External network
$DMZ_NET        = DMZ network
$ALIAS_HOME_NET = Alternative home net
any             = Any IP
! $HOME_NET      = NOT home network
```

---

### **Specific IPs/Subnets:**

```
192.168.1.5                    = Single IP
192.168.1.0/24                 = Subnet
[192.168.1.5,10.0.0.5]         = Multiple IPs
![192.168.1.0/24,10.0.0.0/8]   = Exclude multiple
```

---

### **Ports:**

```
any             = Any port
80              = Specific port
80,443          = Multiple ports
80:443          = Port range
! 80             = Exclude port 80
1024:65535      = High ports
```

---

## **6. DIRECTION (-> dan <>)**

### **Unidirectional (->)**

```
alert http $HOME_NET any -> $EXTERNAL_NET any (...)
```

**Fungsi:**
- Traffic **dari source ke destination**
- Client to Server
- One direction only

---

### **Bidirectional (<>)**

```
alert http $HOME_NET any <> $EXTERNAL_NET any (...)
```

**Fungsi:**
- Traffic **both ways**
- Bisa dari client or server
- Two directions

---

## **7.  RULE OPTIONS (dalam parenthesis)**

### **msg (Message)**

```
alert http any any -> any any (msg:"Potential SQL Injection Detected"; ...)
```

**Penjelasan:**
- Alert message yang akan ditampilkan
- User-friendly description
- Muncul di fast. log
- Penting untuk human readability

---

### **content (Simple Pattern Matching)**

```
content:"<script>";
content:"SELECT";
content:"POST";
content:"|48 54 54 50|";  = Hex untuk "HTTP"
```

**Fungsi:**
- **Search for exact string** dalam traffic
- Case sensitive by default
- Bisa multiple content dalam satu rule
- Biasanya lebih cepat daripada pcre

---

### **nocase (Case Insensitive)**

```
content:"<script>"; nocase;
content:"SELECT"; nocase;
```

**Fungsi:**
- Make pattern matching **case-insensitive**
- `<script>`, `<SCRIPT>`, `<Script>` semua cocok
- Penting untuk catch berbagai variant
- Slightly slower tapi lebih comprehensive

---

### **http_method**

```
content:"POST"; http_method;
content:"GET"; http_method;
content:"PUT"; http_method;
```

**Fungsi:**
- **Specify cek di HTTP method field**
- Memastikan pattern dicek di method saja
- Bukan di body atau headers
- Lebih spesifik & accurate

---

### **http_uri**

```
content:"/login. php"; http_uri;
content:"/admin"; http_uri;
content:"/upload"; http_uri;
```

**Fungsi:**
- **Specify cek di URI field**
- Check di URL path saja
- Exclude query string
- Berguna untuk target specific endpoints

---

### **http_header**

```
content:"Referer"; http_header;
content:"User-Agent"; http_header;
content:"Cookie"; http_header;
```

**Fungsi:**
- **Specify cek di HTTP header fields**
- Check dalam headers (bukan body)
- Useful untuk CSRF, User-Agent spoofing, dll

---

### **http_client_body**

```
content:"<script>"; http_client_body;
content:"password="; http_client_body;
content:"OR"; http_client_body;
```

**Fungsi:**
- **Specify cek di request body**
- Form data, JSON payload, file uploads
- Data yang dikirim client ke server
- Penting untuk SQLi, XSS detection

---

### **http_server_body**

```
content:"<script>"; http_server_body;
content:"error"; http_server_body;
```

**Fungsi:**
- **Specify cek di response body**
- Server response body
- Detect reflected XSS, error messages, dll
- Monitor server-side behavior

---

### **http_content_type**

```
content:"application/json"; http_content_type;
content:"text/html"; http_content_type;
```

**Fungsi:**
- **Check Content-Type header**
- Detect specific media types
- Useful untuk API/JSON attacks

---

### **pcre (Perl Compatible Regular Expression)**

```
pcre:"/(\bOR\b|\bUNION\b)/i";
pcre:"/<img.*onerror/i";
pcre:"/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/";
```

**Komponen Regex:**
- `\b` = Word boundary (exact word)
- `|` = OR operator
- `()` = Group
- `.*` = Any character
- `/i` = Case insensitive flag
- `/` = Delimiter

**Fungsi:**
- **Pattern matching dengan regex**
- More powerful than simple content
- Lebih flexible untuk complex patterns
- Slightly slower tapi lebih comprehensive

---

### **flow (Traffic Direction Control)**

```
flow:established,to_server;
flow:to_client;
flow:from_server;
flow:established;
```

**Opsi:**
- `established` = TCP 3-way handshake complete
- `to_server` = Client to Server direction
- `to_client` = Server to Client direction
- `from_server` = Alternative untuk to_client
- `no_stream` = Not part of stream

**Fungsi:**
- **Control kapan rule triggered**
- `established,to_server` = Request detection
- `to_client` = Response detection
- Berguna untuk reduce false positives

---

### **sid (Signature ID)**

```
sid:1000001;
sid:2000001;
sid:2210050;
```

**Aturan:**
- **Unique identifier** per rule
- Official ET rules: sid >= 2000000
- Custom/Local rules: sid 1000000-1999999
- Snort legacy: sid 1-999999

**Fungsi:**
- Identify specific rule
- Track alerts to specific rule
- Essential untuk correlation

---

### **rev (Revision)**

```
rev:1;
rev:2;
rev:5;
```

**Fungsi:**
- **Version number** rule
- Increment saat rule di-update
- Track perubahan/improvement rule
- Help dalam version control

---

### **classtype (Alert Classification)**

```
classtype:web_application_attack;
classtype:sql_injection;
classtype:cross_site_scripting;
classtype:suspicious_login;
classtype:web_application_activity;
classtype:bad_unknown;
```

**Fungsi:**
- **Categorize alert type**
- Help organization & filtering
- Standard classification
- Useful untuk incident response

---

### **priority (Alert Priority)**

```
priority:1;  = Critical (highest)
priority:2;  = High
priority:3;  = Medium
priority:4;  = Low (lowest)
```

**Fungsi:**
- **Severity/Urgency level**
- Help prioritize incidents
- 1 = immediate attention
- 4 = informational only

---

### **reference (External References)**

```
reference:url,https://www.owasp.org/index.php/SQL_Injection;
reference:cve,2021-12345;
reference:bugtraq,12345;
```

**Fungsi:**
- Link ke external resources
- CVE references
- OWASP guidelines
- Useful untuk incident investigation

---

### **metadata (Custom Metadata)**

```
metadata:policy balanced-ips drop, policy security-ips alert, policy max-detect-ips alert;
metadata:affected_product Windows, Linux;
metadata:cve CVE-2021-12345;
```

**Fungsi:**
- Add custom metadata
- Policy-based rule selection
- Versioning info
- Useful untuk rule management

---

## **8. SURICATA SPECIFIC FEATURES**

### **HTTP Sticky Buffers**

```
content:"SELECT"; http_client_body;
content:"<script>"; http_server_body;
```

**Fungsi:**
- Specify exactly **di mana** cek pattern
- `http_client_body` = request body
- `http_server_body` = response body
- More precise than generic content

---

### **Protocol Specific Keywords**

```
ssl_version:"TLSv1.2";
dns_query;
dns_answer;
dns_rrtype:A;
```

**Fungsi:**
- Target specific protocols
- SSL/TLS inspection
- DNS monitoring
- Protocol-level detection

---

### **Stream Keywords**

```
stream_size:>10000;
stream_size:<100;
```

**Fungsi:**
- Check TCP stream size
- Detect large data transfers
- Useful untuk data exfiltration

---

### **File Keywords (File Extraction)**

```
filename:". exe";
file_data;
file_size:>5000000;
```

**Fungsi:**
- Match on filenames
- Extract suspicious files
- Check file size

---

## **9. CONTOH RULE LENGKAP SURICATA**

### **Example 1: Basic POST Detection**

```
alert http $HOME_NET any -> $EXTERNAL_NET any (msg:"Monitor POST Request"; flow:established,to_server; content:"POST"; http_method; sid:1000001; rev:1; classtype:web_application_activity; priority:3;)
```

**Penjelasan:**
- `alert http` = Alert pada HTTP
- `$HOME_NET any -> $EXTERNAL_NET any` = Internal ke external
- `flow:established,to_server` = Established connection, client to server
- `content:"POST"; http_method;` = POST method
- `sid:1000001` = Rule ID
- `classtype:web_application_activity` = Web activity
- `priority:3` = Medium

**Fungsi:**
- Monitor semua POST requests
- Log untuk tracking

---

### **Example 2: SQL Injection Detection**

```
alert http $HOME_NET any -> $EXTERNAL_NET any (msg:"Possible SQL Injection"; flow:established,to_server; content:"POST"; http_method; pcre:"/(\bSELECT\b|\bUNION\b|\bDROP\b|\bINSERT\b)/i"; http_client_body; sid:1000002; rev:2; classtype:sql_injection; priority:1;)
```

**Penjelasan:**
- `pcre:"/regex/i"` = Regex (case insensitive)
- `\bSELECT\b` = Exact word "SELECT" (word boundary)
- `|` = OR operator
- `http_client_body` = Di request body
- `priority:1` = Critical
- `classtype:sql_injection` = SQL Injection

**Fungsi:**
- Detect SQL keywords (SELECT, UNION, DROP, INSERT)
- High priority
- Check dalam request body

---

### **Example 3: XSS Detection**

```
alert http $HOME_NET any -> $EXTERNAL_NET any (msg:"Possible XSS Attack"; flow:established,to_server; content:"POST"; http_method; pcre:"/(<script|<img.*onerror|javascript:|<iframe|<object|<embed)/i"; http_client_body; sid:1000003; rev:1; classtype:cross_site_scripting; priority:2;)
```

**Penjelasan:**
- Multiple XSS patterns: `<script>`, `<img onerror>`, `javascript:`, dll
- `http_client_body` = Di request body
- `priority:2` = High priority
- `classtype:cross_site_scripting` = XSS

**Fungsi:**
- Detect common XSS vectors
- Catch multiple variants

---

### **Example 4: CSRF via Spoofed Referer**

```
alert http $HOME_NET any -> $EXTERNAL_NET any (msg:"Suspicious Referer Header"; flow:established,to_server; content:"Referer"; http_header; content:"/login.php"; http_uri; content:!"http://localhost|http://192.168"; http_header; sid:1000004; rev:1; classtype:web_application_attack; priority:3;)
```

**Penjelasan:**
- `content:"Referer"; http_header;` = Check Referer header
- `content:! "/localhost|/192.168"` = Exclude local IPs (negation)
- `! ` = NOT operator
- `priority:3` = Medium

**Fungsi:**
- Detect suspicious Referer
- Flag jika dari external source

---

### **Example 5: Admin Panel Access Attempt**

```
alert http $HOME_NET any -> $EXTERNAL_NET any (msg:"Attempt to Access Admin Panel"; flow:established,to_server; content:"GET"; http_method; content:"/admin"; http_uri; sid:1000005; rev:1; classtype:web_application_activity; priority:3;)
```

**Penjelasan:**
- `content:"GET"; http_method;` = GET request
- `content:"/admin"; http_uri;` = URI path /admin
- Simple detection

**Fungsi:**
- Monitor access ke /admin panel
- Useful untuk tracking unauthorized access

---

## **10.  RULE OPTIONS CHEAT SHEET**

| Option | Fungsi | Contoh |
|--------|--------|---------|
| `msg` | Alert message | `msg:"Alert"` |
| `content` | Pattern match | `content:"<script>"` |
| `pcre` | Regex | `pcre:"/regex/i"` |
| `http_method` | HTTP method field | `http_method` |
| `http_uri` | URI field | `http_uri` |
| `http_header` | Header field | `http_header` |
| `http_client_body` | Request body | `http_client_body` |
| `http_server_body` | Response body | `http_server_body` |
| `http_content_type` | Content-Type header | `http_content_type` |
| `nocase` | Case insensitive | `nocase` |
| `flow` | Traffic direction | `flow:established,to_server` |
| `sid` | Rule ID | `sid:1000001` |
| `rev` | Revision | `rev:1` |
| `classtype` | Alert class | `classtype:web_application_attack` |
| `priority` | Severity | `priority:1` |
| `reference` | External ref | `reference:url,https://... ` |
| `metadata` | Custom metadata | `metadata:policy... ` |

---

## **11. BOOLEAN OPERATORS**

### **Dalam content/pcre:**

```
|       = OR (match any)
!        = NOT (exclude/negation)
&       = AND (match all)
()      = Group
```

---

### **Contoh penggunaan:**

```
content:"SELECT|UNION|DROP"           = Match SELECT OR UNION OR DROP
content:!"admin"                       = NOT contain "admin"
pcre:"/(\bOR\b|\bAND\b|\bUNION\b)/i" = Match OR OR AND OR UNION
```

---

## **12. HEX NOTATION (Binary Content)**

```
|3a|     = : (colon)
|3d|     = = (equals)
|2f|     = / (forward slash)
|20|     = (space)
|00|     = NULL byte
|48 54 54 50| = "HTTP" (4 bytes)
|0d 0a|  = \r\n (carriage return + line feed)
```

**Fungsi:**
- Encode special/binary characters
- Useful untuk bypass evasion
- Precise pattern matching

---

