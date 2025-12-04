## **1. PENGENALAN SNORT RULES**

Snort adalah **IDS/IPS (Intrusion Detection/Prevention System)** yang paling populer dan established. 

**Karakteristik Snort:**
- Lebih mature & widely used
- Strong community support
- Banyak pre-made rules (Talos, ET)
- Stricter rule syntax
- Fokus pada performance & reliability

**Perbedaan dengan Suricata:**
- Syntax sedikit berbeda
- Lebih strict validation
- Single-threaded (older versions)
- Output ke alert/log file
- Rule format lebih rigid

---

## **2. STRUKTUR DASAR SNORT RULE**

```
alert tcp $HOME_NET any -> $EXTERNAL_NET any (msg:"Description"; content:"pattern"; sid:123456; rev:1;)
```

**Breakdown:**

| Komponen | Fungsi | Contoh |
|----------|--------|---------|
| `alert` | Action | alert, drop, pass, reject, sdrop |
| `tcp` | Protocol | tcp, udp, icmp, ip |
| `$HOME_NET` | Source IP | Internal network |
| `any` | Source Port | Any port |
| `->` | Direction | Unidirectional |
| `$EXTERNAL_NET` | Destination IP | External network |
| `any` | Destination Port | Any port |
| `(...)` | Options | Pattern & metadata |

---

## **3.  ACTION (alert, drop, pass, reject, sdrop)**

### **alert**
```
alert tcp $HOME_NET any -> $EXTERNAL_NET any (...)
```
- **Generate alert** + log traffic
- Detect tanpa blocking
- Paling umum untuk IDS mode

---

### **drop**
```
drop tcp $HOME_NET any -> $EXTERNAL_NET any (...)
```
- **Block traffic** + generate alert
- Inline mode (IPS)
- Reset connection
- Log untuk analysis

---

### **pass**
```
pass tcp $HOME_NET any -> $EXTERNAL_NET any (...)
```
- **Allow traffic** + skip further rules
- Whitelist traffic
- Stop rule processing

---

### **reject**
```
reject tcp $HOME_NET any -> $EXTERNAL_NET any (...)
```
- **Block traffic** + send RST
- Send reset packet to both sides
- More aggressive than drop

---

### **sdrop**
```
sdrop tcp $HOME_NET any -> $EXTERNAL_NET any (...)
```
- **Silent drop** (no alert)
- Block traffic silently
- No logging
- Useful untuk noise reduction

---

## **4.  PROTOCOL**

### **Protokol yang didukung Snort:**

```
tcp    = TCP (Transmission Control Protocol)
udp    = UDP (User Datagram Protocol)
icmp   = ICMP (ping, traceroute)
ip     = Any IP traffic
```

**Perbedaan:**

| Protocol | Fungsi | Contoh |
|----------|--------|---------|
| `tcp` | Connection-oriented | HTTP, SSH, FTP, Telnet |
| `udp` | Connectionless | DNS, NTP, DHCP, SIP |
| `icmp` | Control messages | Ping, Traceroute |
| `ip` | Generic | Any protocol |

---

### **TCP (Layer 4 Analysis)**

```
alert tcp $HOME_NET any -> $EXTERNAL_NET any (...)
```

**Karakteristik:**
- Reliable, ordered delivery
- Connection-based
- Best untuk application attacks
- Good untuk HTTP, SSH, FTP monitoring

---

### **UDP (Layer 4 Analysis)**

```
alert udp $HOME_NET any -> $EXTERNAL_NET any (...)
```

**Karakteristik:**
- Connectionless, faster
- No guaranteed delivery
- Good untuk DNS, NTP monitoring
- Useful untuk DoS detection

---

### **ICMP (Layer 3 Analysis)**

```
alert icmp $HOME_NET any -> $EXTERNAL_NET any (...)
```

**Karakteristik:**
- Control & diagnostic messages
- Ping requests/replies
- Traceroute
- Can detect reconnaissance

---

### **IP (Generic)**

```
alert ip $HOME_NET any -> $EXTERNAL_NET any (...)
```

**Karakteristik:**
- Any IP protocol
- Most generic
- Catch anomalies
- Useful untuk unusual traffic

---

## **5.  VARIABLES & ADDRESSES**

### **Built-in Variables:**

```
$HOME_NET       = Internal network (config: HOME_NET)
$EXTERNAL_NET   = External network (config: EXTERNAL_NET)
$DMZ_NET        = DMZ network (config: DMZ_NET)
any             = Any IP address
!  $HOME_NET      = NOT home network
```

---

### **Variabel Custom:**

```
HOME_NET [192.168.1.0/24,10.0.0.0/8]
EXTERNAL_NET ! $HOME_NET
SQL_SERVERS [192.168.1.5,192.168.1.6]
WEB_SERVERS [192.168.1.10,192.168.1.11]
```

Defined di `/etc/snort/snort. conf`

---

### **Specific IPs/Subnets:**

```
192.168.1.5                    = Single IP
192.168.1.0/24                 = Subnet (/24 = 254 hosts)
192.168.0.0/16                 = Larger subnet (/16)
[192.168.1.5,10.0.0.5]         = Multiple IPs (list)
![192.168.1.0/24,10.0.0.0/8]   = Exclude multiple
```

---

### **Ports:**

```
any             = Any port (0-65535)
80              = Specific port (HTTP)
443             = HTTPS port
80,443          = Multiple ports
1024:65535      = Port range (ephemeral)
!  22             = Exclude port 22 (SSH)
!  [80,443,8080]  = Exclude multiple ports
```

---

## **6. DIRECTION (-> dan <>)**

### **Unidirectional (->)**

```
alert tcp $HOME_NET any -> $EXTERNAL_NET 80 (...)
```

**Fungsi:**
- Traffic **dari source ke destination**
- One direction only
- `$HOME_NET any -> $EXTERNAL_NET 80` = Internal to external port 80

---

### **Bidirectional (<>)**

```
alert tcp $HOME_NET any <> $EXTERNAL_NET 80 (...)
```

**Fungsi:**
- Traffic **both ways**
- Trigger dari salah satu arah
- `$HOME_NET any <> $EXTERNAL_NET 80` = Any direction between internal & external port 80

---

## **7. RULE OPTIONS (dalam parenthesis)**

### **msg (Message)**

```
msg:"Possible SQL Injection Attack";
msg:"Buffer Overflow Detected";
msg:"Reconnaissance Activity Detected";
```

**Penjelasan:**
- **Alert message yang ditampilkan**
- User-friendly description
- Muncul di alert file
- Harus descriptive

**Format:**
- Gunakan quotes
- Hindari special characters
- Keep concise tapi informative

---

### **content (Pattern Matching)**

```
content:"SELECT";
content:"<script>";
content:"GET";
content:"|48 54 54 50|";  = Hex untuk "HTTP"
```

**Fungsi:**
- **Search exact string** dalam traffic
- Case sensitive by default
- Multiple content dalam satu rule
- Biasanya lebih cepat

---

### **nocase (Case Insensitive)**

```
content:"SELECT"; nocase;
content:"<script>"; nocase;
```

**Fungsi:**
- Make pattern **case-insensitive**
- `SELECT`, `select`, `Select` semua cocok
- Penting untuk catch variations
- Slightly slower tapi comprehensive

---

### **Content Modifiers**

#### **depth**
```
content:"SELECT"; depth:100;
```
- Limit search ke first 100 bytes
- Performance optimization
- Search dari start of buffer

#### **offset**
```
content:"SELECT"; offset:10;
```
- Start searching dari byte 10
- Skip first N bytes
- Combined with depth

#### **distance**
```
content:"SELECT"; content:"UNION"; distance:0;
```
- Distance antara content patterns
- `distance:0` = immediately adjacent
- Useful untuk multi-pattern rules

#### **within**
```
content:"SELECT"; content:"UNION"; within:100;
```
- UNION harus dalam 100 bytes dari SELECT
- Combined with distance

---

### **http_method**

```
content:"POST"; http_method;
content:"GET"; http_method;
```

**Fungsi:**
- **Check HTTP method**
- Snort HTTP preprocessing
- Match dalam method field saja

---

### **http_uri**

```
content:"/login. php"; http_uri;
content:"/admin"; http_uri;
```

**Fungsi:**
- **Check URI path**
- Exclude query string
- Snort HTTP preprocessing

---

### **http_header**

```
content:"Referer"; http_header;
content:"User-Agent"; http_header;
```

**Fungsi:**
- **Check HTTP headers**
- Match dalam header fields
- Useful untuk header-based attacks

---

### **http_client_body**

```
content:"password"; http_client_body;
content:"<script>"; http_client_body;
```

**Fungsi:**
- **Check request body**
- Form data, POST payload
- HTTP preprocessing required

---

### **http_server_body**

```
content:"<script>"; http_server_body;
content:"error"; http_server_body;
```

**Fungsi:**
- **Check response body**
- Server response
- Monitor reflected XSS

---

### **uricontent (Deprecated, use http_uri)**

```
uricontent:"login.php";
```

**Note:** Deprecated dalam Snort 3, gunakan `content` + `http_uri` instead

---

### **pcre (Perl Compatible Regular Expression)**

```
pcre:"/(\bSELECT\b|\bUNION\b)/i";
pcre:"/<img.*onerror/i";
pcre:"/[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}/";
```

**Regex Components:**
- `\b` = Word boundary
- `|` = OR
- `()` = Group
- `.*` = Any character
- `[0-9]` = Digit
- `/i` = Case insensitive flag
- `$` = End of line
- `^` = Start of line

**Fungsi:**
- **Complex pattern matching**
- More flexible than content
- Slower tapi powerful

---

### **flow (Flow Control)**

```
flow:established,to_server;
flow:to_client;
flow:established;
```

**Opsi:**
- `established` = TCP 3-way handshake complete
- `stateless` = No stream tracking
- `to_server` = Client to Server
- `to_client` = Server to Client
- `from_server` = Alternative to_client

**Fungsi:**
- **Control kapan rule triggered**
- `established,to_server` = Request detection
- `to_client` = Response detection
- Reduce false positives

---

### **flags (TCP Flags)**

```
flags:S;        = SYN flag set
flags:A;        = ACK flag set
flags:F;        = FIN flag set
flags:R;        = RST flag set
flags:S,+A;     = SYN set, ACK must be clear
flags:SA;       = SYN and ACK set
```

**Flags:**
- `S` = SYN (synchronize)
- `A` = ACK (acknowledge)
- `F` = FIN (finish)
- `R` = RST (reset)
- `P` = PSH (push)
- `U` = URG (urgent)
- `0` = Reserved

**Fungsi:**
- **Check TCP flags**
- Detect specific connection states
- Useful untuk reconnaissance detection

---

### **seq (TCP Sequence Number)**

```
seq:0;
seq:>1000;
```

**Fungsi:**
- Check TCP sequence numbers
- Less commonly used

---

### **ack (TCP Acknowledgment Number)**

```
ack:0;
ack:>5000;
```

**Fungsi:**
- Check ACK numbers
- Rare usage

---

### **window (TCP Window Size)**

```
window:512;
window:<1024;
```

**Fungsi:**
- Check TCP window size
- Detect unusual window sizes
- Useful untuk OS fingerprinting detection

---

### **itype (ICMP Type)**

```
itype:8;  = Echo request (ping)
itype:0;  = Echo reply
itype:11; = Time exceeded
```

**ICMP Types:**
- `0` = Echo Reply
- `3` = Destination Unreachable
- `8` = Echo Request (ping)
- `11` = Time Exceeded

**Fungsi:**
- **Check ICMP message type**
- Useful untuk ICMP-based attacks

---

### **icode (ICMP Code)**

```
icode:0;
icode:>3;
```

**Fungsi:**
- Check ICMP code
- Provides more detail than type

---

### **dsize (Data Size)**

```
dsize:>1000;
dsize:<100;
dsize:100;
```

**Fungsi:**
- Check payload size
- Detect unusually large/small packets
- Useful untuk buffer overflow detection

---

### **sid (Signature ID)**

```
sid:1000001;
sid:2000001;
sid:2210050;
```

**Aturan:**
- **Unique identifier** per rule
- Snort Official: sid 1-999999
- ET/Community: sid 2000000+
- Custom/Local: sid 1000000+

**Fungsi:**
- Identify specific rule
- Track alerts
- Cross-reference documentation

---

### **rev (Revision)**

```
rev:1;
rev:2;
rev:5;
```

**Fungsi:**
- **Version/revision number**
- Increment pada update
- Track changes

---

### **classtype (Classification)**

```
classtype:attempted-recon;
classtype:web_application_attack;
classtype:sql_injection;
classtype:cross_site_scripting;
classtype:suspicious_login;
classtype:bad_unknown;
```

**Common Classtypes:**
- `attempted-recon` = Reconnaissance
- `successful-recon-limited` = Limited info gathering
- `successful-recon-largescale` = Large-scale recon
- `suspicious-login` = Suspicious login
- `suspicious-filename-detect` = Suspicious file
- `web_application_attack` = Web app attack
- `sql_injection` = SQL Injection
- `cross_site_scripting` = XSS
- `denial_of_service` = DoS
- `malware-cnc` = C&C communication

**Fungsi:**
- **Categorize alert type**
- Organization & filtering
- Help incident response

---

### **priority (Alert Priority)**

```
priority:1;
priority:2;
priority:3;
```

**Levels:**
- `1` = Critical/High priority
- `2` = Medium priority
- `3` = Low priority

**Fungsi:**
- **Severity level**
- Prioritize incidents
- Correlate with classtype

---

### **reference (External References)**

```
reference:url,https://www.owasp.org/index.php/SQL_Injection;
reference:cve,2021-12345;
reference:bugtraq,12345;
```

**Formats:**
- `url` = URL reference
- `cve` = CVE ID
- `bugtraq` = Bugtraq ID
- `nessus` = Nessus plugin ID

**Fungsi:**
- Link ke external resources
- Additional information
- Help investigation

---

### **metadata (Custom Metadata)**

```
metadata:policy max-detect-ips drop, policy security-ips alert;
metadata:affected_product Windows, Linux;
metadata:cve CVE-2021-12345;
```

**Fungsi:**
- Custom metadata
- Policy-based rule selection
- Version tracking

---

## **8.  SNORT SPECIFIC FEATURES**

### **Flowbits (Stream State Tracking)**

```
flowbits:set,has. http.uri;
flowbits:isset,has.http.uri;
flowbits:noalert;
```

**Fungsi:**
- Track state across packets
- Correlate related events
- Set flags untuk subsequent rules
- Complex attack detection

---

### **Asn1 (ASN. 1 Detection)**

```
content:"|30|"; asn1:bitstring_overflow;
```

**Fungsi:**
- Detect ASN. 1 encoding attacks
- Bitstring overflow detection

---

### **Byte Extract/Test**

```
byte_extract:1,0,extracted_value;
byte_test:1,&,0xFF,extracted_value;
```

**Fungsi:**
- Extract bytes dari traffic
- Test extracted values
- Advanced packet analysis

---

## **9. CONTOH RULE LENGKAP SNORT**

### **Example 1: Port Scan Detection (SYN)**

```
alert tcp $EXTERNAL_NET any -> $HOME_NET any (msg:"Possible Reconnaissance Activity - SYN Scan"; flags:S,+A; flow:stateless; dsize:0; sid:1000001; rev:1; classtype:attempted-recon; priority:3;)
```

**Penjelasan:**
- `flags:S,+A` = SYN set, ACK must NOT be set (initial SYN)
- `flow:stateless` = Stateless (no stream tracking)
- `dsize:0` = No data (SYN has no payload)
- `classtype:attempted-recon` = Reconnaissance
- `priority:3` = Low priority

**Fungsi:**
- Detect port scanning (SYN scan)
- Look for SYN packets tanpa ACK

---

### **Example 2: Telnet Access Attempt**

```
alert tcp $EXTERNAL_NET any -> $HOME_NET 23 (msg:"Attempted Telnet Connection"; flow:established,to_server; content:"USER"; sid:1000002; rev:1; classtype:suspicious-login; priority:2;)
```

**Penjelasan:**
- `$EXTERNAL_NET any -> $HOME_NET 23` = External to port 23 (Telnet)
- `flow:established,to_server` = Established connection, client to server
- `content:"USER"` = Telnet USER command
- `classtype:suspicious-login` = Suspicious login
- `priority:2` = Medium

**Fungsi:**
- Detect Telnet login attempts
- Alert on USER command

---

### **Example 3: SQL Injection Detection**

```
alert tcp $HOME_NET any -> $EXTERNAL_NET any (msg:"Possible SQL Injection Attack"; flow:established,to_server; content:"POST"; http_method; pcre:"/(\bSELECT\b|\bUNION\b|\bDROP\b|\bINSERT\b)/i"; http_client_body; sid:1000003; rev:2; classtype:web_application_attack; priority:1;)
```

**Penjelasan:**
- `flow:established,to_server` = Request flow
- `content:"POST"; http_method;` = POST method
- `pcre:"/regex/i"` = Regex (case insensitive)
- `http_client_body` = In request body
- `classtype:web_application_attack` = Web attack
- `priority:1` = Critical

**Fungsi:**
- Detect SQL injection attempts
- Match SQL keywords
- High priority alert

---

### **Example 4: XSS Detection**

```
alert tcp $HOME_NET any -> $EXTERNAL_NET any (msg:"Possible XSS Attack Detected"; flow:established,to_server; content:"POST"; http_method; pcre:"/(<script|<img.*onerror|javascript:|<iframe)/i"; http_client_body; sid:1000004; rev:1; classtype:web_application_attack; priority:1;)
```

**Penjelasan:**
- Multiple XSS patterns
- `pcre` dengan multiple pattern
- `http_client_body` = POST data
- `priority:1` = Critical

**Fungsi:**
- Detect XSS attempts
- Catch multiple XSS vectors

---

### **Example 5: DNS Query to Suspicious Domain**

```
alert udp $HOME_NET any -> $EXTERNAL_NET 53 (msg:"Possible DNS Tunneling - Suspicious Query"; flow:established,to_server; content:"|01|"; offset:2; depth:1; content:"example"; http_uri; sid:1000005; rev:1; classtype:suspicious-traffic; priority:2;)
```

**Penjelasan:**
- `udp $HOME_NET any -> $EXTERNAL_NET 53` = DNS queries (port 53)
- `content:"|01|"; offset:2; depth:1` = DNS query flag
- `content:"example"` = Domain name
- `classtype:suspicious-traffic` = Suspicious

**Fungsi:**
- Detect DNS queries ke suspicious domains
- Monitor DNS activity

---

### **Example 6: Large File Transfer (Data Exfiltration)**

```
alert tcp $HOME_NET any -> $EXTERNAL_NET any (msg:"Possible Data Exfiltration - Large Transfer"; flow:established,to_server; dsize:>1000000; sid:1000006; rev:1; classtype:suspicious-traffic; priority:2;)
```

**Penjelasan:**
- `dsize:>1000000` = Payload > 1MB
- Large data transfer
- Possible exfiltration
- `priority:2` = Medium

**Fungsi:**
- Detect large outbound transfers
- Suspicious file exfiltration

---

### **Example 7: ICMP Flood Detection**

```
alert icmp $HOME_NET any -> $EXTERNAL_NET any (msg:"Possible ICMP Flood Detected"; itype:8; icode:0; dsize:>1000; sid:1000007; rev:1; classtype:denial_of_service; priority:1;)
```

**Penjelasan:**
- `icmp` = ICMP protocol
- `itype:8` = Echo request (ping)
- `icode:0` = Echo code
- `dsize:>1000` = Large payload (unusual for ping)
- `classtype:denial_of_service` = DoS
- `priority:1` = Critical

**Fungsi:**
- Detect unusual ICMP traffic
- Possible DoS attack

---

### **Example 8: Admin Page Access**

```
alert tcp $HOME_NET any -> $EXTERNAL_NET any (msg:"Unauthorized Admin Access Attempt"; flow:established,to_server; content:"GET"; http_method; content:"/admin|%2fadmin"; http_uri; nocase; sid:1000008; rev:1; classtype:suspicious-login; priority:2;)
```

**Penjelasan:**
- `content:"/admin|%2fadmin"` = "/admin" atau URL encoded "%2fadmin"
- `nocase` = Case insensitive
- `classtype:suspicious-login` = Suspicious login
- `priority:2` = Medium

**Fungsi:**
- Monitor access ke admin pages
- Track unauthorized attempts

---

## **10. RULE OPTIONS COMPARISON TABLE**

| Option | Snort | Suricata | Fungsi |
|--------|-------|----------|--------|
| `content` | ✅ | ✅ | Simple pattern |
| `pcre` | ✅ | ✅ | Regex |
| `http_method` | ✅ | ✅ | HTTP method |
| `http_uri` | ✅ | ✅ | URI path |
| `http_header` | ✅ | ✅ | Headers |
| `http_client_body` | ✅ | ✅ | Request body |
| `http_server_body` | ✅ | ✅ | Response body |
| `flow` | ✅ | ✅ | Traffic direction |
| `sid` | ✅ | ✅ | Rule ID |
| `rev` | ✅ | ✅ | Revision |
| `classtype` | ✅ | ✅ | Classification |
| `priority` | ✅ | ✅ | Priority |
| `flags` | ✅ | ❌ | TCP flags |
| `dsize` | ✅ | ❌ | Data size |
| `itype` | ✅ | ❌ | ICMP type |
| `flowbits` | ✅ | ❌ | State tracking |

---

## **11. BOOLEAN OPERATORS & MODIFIERS**

### **Content Operators:**

```
|       = OR (in content)
!         = NOT (negation)
&       = AND
$        = Hex value
()      = Group
```

---

### **Contoh penggunaan:**

```
content:"/admin|/root"           = "/admin" OR "/root"
content:! "/public"               = NOT "/public"
content:"SELECT|UNION|DROP"      = SQL keywords
flags:S,+A                       = SYN set, ACK NOT set
```

---

## **12. HEX NOTATION**

```
|3a|     = : (colon)
|3d|     = = (equals)
|2f|     = / (forward slash)
|20|     = (space)
|00|     = NULL byte
|0d 0a|  = \r\n (carriage return + line feed)
|48 54 54 50| = "HTTP"
|25|     = %
```

**Fungsi:**
- Binary/special character matching
- Bypass evasion techniques

---
