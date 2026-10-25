# DSWD Queuing & Appointment Management System (QMS)
## Comprehensive User Manual (Lahat ng User Level)

---

## Talaan ng Nilalaman (Table of Contents)
1. [Panimula (Introduction)](#1-panimula-introduction)
2. [Mga Antas ng Gumagamit (User Levels & Roles)](#2-mga-antas-ng-gumagamit-user-levels--roles)
3. [Gabay para sa Publiko / Kliyente (Public / Client Guide)](#3-gabay-para-sa-publiko--kliyente-public--client-guide)
4. [Gabay para sa Receptionist (Receptionist Guide)](#4-gabay-para-sa-receptionist-receptionist-guide)
5. [Gabay para sa Social Worker (Social Worker Guide)](#5-gabay-para-sa-social-worker-social-worker-guide)
6. [Gabay para sa Approving Officer (Approving Officer Guide)](#6-gabay-para-sa-approving-officer-approving-officer-guide)
7. [Gabay para sa Releasing / Cashier - Paymaster (Paymaster Guide)](#7-gabay-para-sa-releasing--cashier---paymaster-paymaster-guide)
8. [Gabay para sa Administrator (System Administrator Guide)](#8-gabay-para-sa-administrator-system-administrator-guide)
9. [Public Live Queue Board System](#9-public-live-queue-board-system)
10. [Mga Madalas Itanong at Troubleshooting (FAQs)](#10-mga-madalas-itanong-at-troubleshooting-faqs)

---

## 1. Panimula (Introduction)

Ang **DSWD Queuing and Appointment Management System (QMS)** ay idinisenyo upang pabilisin, gawing maayos, at gawing transparent ang pagbibigay ng ayuda sa ilalim ng **Assistance to Individuals in Crisis Situation (AICS)** ng Department of Social Welfare and Development (DSWD).

### Pangunahing Layunin:
- **Zero Confusion:** Malinaw na pagkakaiba ng **Priority Lane (🔴 Red)** at **Regular Lane (🔵 Blue)**.
- **Role-Based Workflow:** Bawat tanggapan (Desk) ay may tiyak na pananagutan.
- **Audit Transparency:** Detalyadong Activity Logs at opisyal na DSWD Letterhead sa lahat ng PDF reports.

---

## 2. Mga Antas ng Gumagamit (User Levels & Roles)

| Antas / Role | Pangunahing Tungkulin | Access Scope |
|---|---|---|
| **Public / Client** | Online Pre-Registration, Pag-track ng Status ng Aplikasyon | Public Portal (`/apply`, `/track-application`, `/public/queue-board`) |
| **Receptionist** | Walk-in Intake, Pagkuha ng ID/Doc via Webcam o Scanner, Pag-confirm ng Online Arrival, Issuance ng Queue Ticket | Receptionist Portal (`/receptionist/*`) |
| **Social Worker** | Pagsasagawa ng Case Assessment (GIS), Pagtatakda ng Halaga ng Ayuda, Pag-hold o Pagpasa ng Kaso | Social Worker Portal (`/social-worker/*`) |
| **Approving Officer** | Pagsusuri (Review) ng Assessment, Pag-apruba (Approve) o Pagbabalik (Return) ng Kaso | Approving Portal (`/approving-officer/*`) |
| **Releasing / Cashier** | Pag-disburse ng Outright Cash / Ayuda, Pag-mark ng Completed Transaction | Cashier Portal (`/cashier/*`, Releasing Desk) |
| **Administrator** | Overall System Management, User Accounts, Live Queue Monitor, Reports Export, Backup & Restore, Audit Logs | Admin Portal (`/admin/*`) |

---

## 3. Gabay para sa Publiko / Kliyente (Public / Client Guide)

### A. Online Pre-Registration (`/apply`)
1. Pumunta sa web browser at buksan ang `/apply`.
2. Punan ang mga personal na detalye:
   - Pangalan, Kasarian, Kaarawan (awtomatikong kinakalkula ang Edad).
   - **Contact Number:** Siguraduhing **eksaktong 11-digit mobile number** simula sa `09` (hal. `09123456789`). Ang sistema ay hindi tatanggap ng kulang, sobra, o may titik.
   - Tirahan (Rehiyon, Lalawigan, Lungsod/Munisipyo, Barangay).
   - Valid ID (piliin ang uri at ilagay ang ID number).
3. Piliin ang kategorya ng kliyente:
   - *Senior Citizen* o *Men/Women in difficult circumstances* ay awtomatikong itatala bilang **Priority Lane**.
4. I-upload ang kopya ng Valid ID at iba pang kaugnay na dokumento (Barangay Indigency, Medical Certificate, etc.).
5. Pindutin ang **Submit Application**.
6. **I-save ang iyong Reference Code / QR Code.** Ito ang gagamitin upang masubaybayan ang iyong pila at ipakita sa DSWD Reception Desk pagdating.

### B. Pag-track ng Aplikasyon (`/track-application`)
1. Buksan ang `/track-application`.
2. Ilagay ang iyong **Reference Code** o **Control Number**.
3. Ilagay ang iyong **11-digit Contact Number** (ang mismong ginamit sa rehistro).
4. Makikita ang real-time status: *Pre-registered*, *Under Assessment*, *Approved*, o *Ready for Releasing*.

---

## 4. Gabay para sa Receptionist (Receptionist Guide)

### A. Pag-login at Dashboard
- Mag-login gamit ang iyong Receptionist account sa `/login`.
- Dadalhin ka sa **Receptionist Dashboard** kung saan makikita ang kabuuang bilang ng nakapila ngayon.

### B. Pag-intake ng Walk-in Client (`/receptionist/clients/create`)
1. Pindutin ang **Register New Client**.
2. Punan ang Personal Information ng kliyente.
3. Ilagay ang **11-digit Contact Number** (`09XXXXXXXXX`).
4. Piliin ang **Category** at **Subcategory**:
   - Kung ang kliyente ay Senior Citizen, PWD, o Buntis, itatalaga ito bilang **Priority Lane (P-xxx)**.
   - Kung ordinaryong aplikante, itatalaga ito bilang **Regular Lane (R-xxx)**.
5. Piliin ang **Type of Assistance** (Cash Relief, Medical, o Funeral Assistance).
   > **Tandaan:** Hindi na tinatanong ang *Amount* sa Receptionist form. Ang Social Worker ang opisyal na magtatakda ng nararapat na halaga ng tulong pinansyal.
6. Pindutin ang **Submit & Generate Queue Ticket**.

### C. Pag-confirm ng Online Arrival (`/receptionist/online-registrations`)
1. Hanapin ang pangalan o Reference Number ng online applicant.
2. I-verify ang physical presence ng kliyente.
3. Pindutin ang **Confirm Arrival** upang mabigyan sila ng opisyal na Queue Ticket para sa araw na iyon.

### D. Document Intake & Verification (`/receptionist/validation`)
1. Sa **Validation Queue**, i-click ang pangalan ng kliyente.
2. Sa ilalim ng bawat required document:
   - **📷 Capture via Webcam:** Pindutin upang magbukas ang live video preview sa camera. Itapat ang ID o dokumento at pindutin ang **Snap & Attach Photo**.
   - **📁 Scan / Choose File:** Gamitin kung gumagamit ng desktop flatbed scanner o nakalagay na sa computer ang scanned file.
   - *Fallback:* Kung walang nakakabit na webcam ang computer, awtomatikong mag-bubukas ang File Chooser/Scanner.
3. Kapag kumpleto ang mga dokumento, pindutin ang **Confirm Uploaded** (dating "Verify File").
4. Pindutin ang **Proceed to Social Worker Assessment** upang umabante ang ticket sa susunod na counter.

---

## 5. Gabay para sa Social Worker (Social Worker Guide)

### A. Intake Assessment (`/social-worker/assessment`)
1. Sa iyong dashboard, makikita ang mga kliyenteng naghihintay mula sa Reception/Validation.
2. Pindutin ang **Start Assessment / Call Ticket**.
3. Suriin ang mga nakakabit na dokumento at ID na kinuha ng Receptionist.
4. Isagawa ang panayam (Interview) batay sa General Intake Sheet (GIS):
   - Alamin ang sitwasyon ng pamilya o indibidwal.
   - Tukuyin ang tamang halaga ng tulong batay sa DSWD guidelines.
5. Ilagay ang **Social Worker Case Findings** at ang **Approved Assistance Amount (PHP)**.
6. **Mga Pagpipilian sa Aksyon:**
   - **Recommend for Approval:** Ipasa ang kaso sa Approving Officer.
   - **Put On-Hold:** Kung may kulang na karagdagang dokumento o kailangan ng follow-up interview.
   - **Return to Receptionist:** Kung may mali sa naunang profile information.

---

## 6. Gabay para sa Approving Officer (Approving Officer Guide)

### A. Case Review (`/approving-officer/review`)
1. Tingnan ang listahan ng mga kasong inendorso ng Social Worker.
2. Buksan ang case folder upang makita:
   - Client Identity at Category (Priority / Regular)
   - Social Worker Assessment Notes at Rekomendadong Halaga
   - Attachments at Validated Documents
3. **Pinal na Desisyon:**
   - **Approve:** Awtomatikong magpapadala ng abiso sa Releasing Desk / Cashier para sa disbursement.
   - **On-Hold:** Pansamantalang i-pause ang kaso kung may kailangang beripikasyon.
   - **Disapprove / Return:** Ibalik sa Social Worker kalakip ang opisyal na dahilan (Remarks).

---

## 7. Gabay para sa Releasing / Cashier - Paymaster (Paymaster Guide)

### A. Pag-release ng Ayuda (`/cashier/dashboard`)
1. Tawagin ang Queue Number ng kliyente (makikita sa Ready for Releasing column).
2. I-verify ang pagkakakilanlan ng kliyente gamit ang kanilang orihinal na Valid ID at Queue Slip.
3. Ibigay ang aprubadong halaga ng ayuda (Cash Relief, Medical Assistance voucher, o Funeral Assistance grant).
4. Papirmahin ang kliyente sa Acknowledgement Receipt / Payroll Sheet.
5. Pindutin ang **Release & Complete**. Awtomatikong ma-tatapos ang pila at magiging *Completed* ang status sa system monitor.

---

## 8. Gabay para sa Administrator (System Administrator Guide)

### A. Interactive Admin Dashboard (`/admin/dashboard`)
- **Clickable Stat Cards:**
  - *Total Queues Today* → Pumupunta sa kumpletong Queue Monitor.
  - *Currently Serving* → Naka-filter sa mga kasalukuyang sinisilbihang kliyente.
  - *Completed Today* → Naka-filter sa mga matagumpay na na-release.
  - *Cancelled / No Show* → Naka-filter sa mga kinanselang tiket.
- **Priority Indicators sa Live Queues:**
  - Ang mga tiket ay may malinaw na **🔴 PRIORITY (Red)** at **🔵 REGULAR (Blue)** badges.
  - May kasamang sub-category indicators (Senior Citizen, PWD, Solo Parent, atbp.).

### B. User Management (`/admin/users`)
1. Pindutin ang **Add New User**.
2. Ipasok ang impormasyon ng kawani:
   - Pangalan, Username, License Number, Contact Number (`09XXXXXXXXX`).
   - **Email Address & Confirm Email Address:** Parehong kailangang itugma upang maiwasan ang maling email.
   - **Password & Confirm Password:** Minimum 8 characters.
   - Role (Admin, Receptionist, Social Worker, Approving Officer, Paymaster).
3. Pindutin ang **Save User**.

### C. Activity Logs & Audit Trail (`/admin/activitylogs`)
- Ang table ay may 5 detalyadong hanay:
  1. **Date & Timestamp:** Kasama ang petsa, oras, at relative time (e.g., *2 mins ago*).
  2. **Staff / Actor & Role:** Pangalan ng kawani kasama ang kanilang system role badge.
  3. **System Module:** Tinutukoy kung ito ay *Reception / Intake*, *Assessment (SW)*, *Approval Desk*, *Releasing / Paymaster*, *User Management*, o *System Backup*.
  4. **Action Event:** Malinaw na action badge (Success, Info, Danger).
  5. **Audit Record & Details:** Buong tala ng ginawang pagbabago.

### D. Official Reports Download (`/admin/*`)
- Maaaring mag-export sa **PDF** o **Excel** para sa:
  - *Daily Client Report*
  - *Monthly Transaction Report*
  - *Queue Performance Report*
  - *Client Processing History*
- **Opisyal na DSWD Letterhead:** Lahat ng na-download na PDF ay may official Republic of the Philippines at DSWD logo, tanggapan, Crisis Intervention Section (CIS) header, petsa, at control reference code.

---

## 9. Public Live Queue Board System (`/public/queue-board`)

Ang Live Queue Board ay idinisenyo para sa mga malalaking LED TVs o monitor sa waiting lobby ng DSWD office.

### Mga Katangian:
1. **Vertical Separator Line:** May malinaw at matibay na linyang naghihiwalay sa Regular Lane at Priority Lane.
2. **Color-Coded Attention:**
   - **🔴 RED LANE (Priority):** Para sa Senior Citizens, PWDs, Buntis, at may kapansanan. May pulsing red indicator at standout alert text.
   - **🔵 BLUE LANE (Regular):** Para sa lahat ng regular na aplikante gamit ang DSWD royal blue theme.
3. **Real-time Audio / Visual Updates:** Gumagamit ng WebSockets (Laravel Echo / Reverb) upang awtomatikong mag-refresh kapag may tinawag na bagong numero.

---

## 10. Mga Madalas Itanong at Troubleshooting (FAQs)

### Q1: Bakit hindi tumatanggap ng higit sa 11 numero ang Contact Number?
> **Sagot:** Alinsunod sa standard mobile format ng Pilipinas (`09XXXXXXXXX`), nililimitahan ang input sa eksaktong 11 numero upang maiwasan ang maling format at typographical errors sa pagpapadala ng SMS notification.

### Q2: Ano ang gagawin kung ayaw magbukas ng Webcam sa Validation?
> **Sagot:** Siguraduhing pinayagan ang camera permission sa browser (`Allow Camera Access`). Kung walang nakakabit na webcam sa desktop PC, pindutin lamang ang **📁 Scan / Choose File** upang mag-upload mula sa scanner o local folder.

### Q3: Sino ang nagtatakda ng halaga ng ayuda?
> **Sagot:** Ang lisensyadong **Social Worker** lamang ang may kapangyarihang magtakda ng halaga ng tulong pinansyal pagkatapos ng Case Assessment alinsunod sa umiiral na DSWD guidelines.

---
*DSWD AICS Queue Management System • All Rights Reserved*
