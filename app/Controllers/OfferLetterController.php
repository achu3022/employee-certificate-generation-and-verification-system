<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\EmployeeModel;
use App\Libraries\CustomTCPDF;

class OfferLetterController extends Controller
{
    public function generate()
    {
        // Debug: log all POST data
        file_put_contents('/tmp/offer_debug.txt', print_r($this->request->getPost(), true), FILE_APPEND);
        $employeeId = $this->request->getPost('employee_id');
        $joiningDate = $this->request->getPost('joining_date');
        $salary = $this->request->getPost('salary');
        $reportingManager = $this->request->getPost('reporting_manager');
        $date = date('d-m-Y');
        if (!$employeeId || !$joiningDate || !$salary || !$reportingManager) {
            return $this->response->setStatusCode(400)->setBody('Missing parameters');
        }
        
        $employeeModel = new EmployeeModel();
        $emp = $employeeModel->find($employeeId);
        if (!$emp) {
            return $this->response->setStatusCode(404)->setBody('Employee not found');
        }

        // Create PDF
        $pdf = new CustomTCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('SMEC');
        $pdf->SetTitle('Offer Letter - ' . $emp['name']);
        $pdf->SetSubject('Offer Letter');
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(15, 30, 15);
        $pdf->SetAutoPageBreak(true, 20);
        $pdf->AddPage();

        // Set background image to cover the entire page
        $bgPath = FCPATH . 'exp-backgroung.jpg';
        if (file_exists($bgPath)) {
            $pdf->Image(
                $bgPath,
                0, 0,
                $pdf->getPageWidth(),
                $pdf->getPageHeight(),
                '', '', '', false, 300, '', false, false, 0, false, false
            );
        }

        // Now re-enable auto page break and set your desired margins for content
        $pdf->SetAutoPageBreak(true, 0);
        $pdf->SetMargins(15, 30, 15); // <-- adjust this value for your desired top padding

        // Move down to clear the logo
        $pdf->Ln(30); // Adjust 80 to match your logo height

        // --- Offer Letter Content ---
        $html = "<p><b>Name:</b> {$emp['name']}</p>
        <p><b>Date:</b> $date</p>
        <br>
        <p>Dear Mr./Ms./Mrs. {$emp['name']},</p>
        <p>Concerning your application and the interview, you had with us, we are pleased to offer you an appointment with SMEC Automation Pvt. Ltd. (“Company”), on the following terms and conditions:</p>
        <ol style='text-align:left;'>
        <li><b>Date of Joining & Work Location:</b> Your appointment becomes effective from the date of joining the services of the Company, which date shall be <b>$joiningDate</b> or any mutually agreed date as <b>{$emp['designation']}</b>. Your work location would be Cochin or any other location as may be assigned by the Company. The Company reserves the right to transfer you to any location, as the Company may deem fit, from time to time. Working hours will be 9.00 am to 6.00 pm, Monday to Saturday.</li>
        <li><b>Term:</b> The term of this Offer would be for 6 months (approximately), commencing from your date of joining. Your salary will be <b>INR $salary per month</b>. This Offer will automatically expire upon the completion of this term unless terminated earlier as per the provisions of Clause 9 of this Agreement.</li>
        <li><b>Background Check:</b> The Company may, at its discretion, conduct background verification, before or at any time after commencement of this Agreement, to verify, including but not limited to, your professional certifications, designations or licenses, educational background, identity, proof of age, address, past work experience (if any) and criminal records. You hereby provide your express consent to the Company for conducting such background checks. This Agreement is subject to validation of any information provided by you to the Company and the satisfactory outcome of the pre-employment screening activities (including background verification and criminal history check).</li>
        <li><b>Offer of permanent position:</b> It shall not be obligatory on the part of the Company to offer a permanent position to you on the expiry of this Offer. This offer of employment will be subject to satisfactory performance during the probation period (6 months from the date of Joining) and also subject to production of necessary documents including educational and professional certificates and may be rescinded in the event such necessary documents are not provided to the Company. Upon satisfying the above conditions, your probation period will be complete. However, the Company may at its sole discretion and its business requirements may decide not to extend an offer of employment. Moreover, if the Company finds that you have not achieved your scope of work (Annexure ‘I’) on probation period, the Company will have the right to terminate your employment even after the permanent position has been offered.</li>
        <li><b>Department, Designation & Reporting Manager:</b><br>
        Department: {$emp['department']}<br>
        Designation: {$emp['designation']}<br>
        Reporting Manager: $reportingManager
        </li>
        <li><b>Company Policies:</b> You will be governed by the Company’s policies, regulations, and procedures on office timings, anti-sexual harassment, leave, travel, transfers, misconduct, etc., presently in force or as introduced/amended from time to time. You are eligible for leave as per the Company’s leave policy, which can be viewed under the ‘Policies’ tab in your ‘Employee Service Platform Account’ and/or the ‘Employee’s Handbook’ provided to you.</li>
        <li><b>Leaves:</b> You will be entitled to get 1 casual leave/sick leave per month. Employees whose date of joining service falls between the 1st to the 15th of a month are entitled to get the leave credit for that month. Employees whose date of joining service falls between the 16th to the end of the month are not entitled to the leave credit for that month.</li>
        <li><b>Absence from duty:</b> When an employee takes off from duty without prior leave approval or proper intimation under certain unavoidable circumstances, then those days/days will be treated as absence from duty. The days of absence will be treated under loss of pay. The employee has to report to his / her department head on re-joining duty from absence and provide valid reasons for absence in writing before taking up work again.</li>
        <li><b>Termination:</b> Subject to Clause 2, your services may be terminated in the following manner:<br>
        a. The Company will be entitled to terminate your services by giving you 48 hours’ notice in writing, or by payment of 48 hours’ salary in lieu of such notice. In the event you desire to leave the services of the Company, you will be required to give the Company 48 hours’ notice in writing or 48 hours’ salary in lieu of such notice.<br>
        b. In the event of termination on disciplinary grounds including but not limited to embezzlement, fraud, gross negligence, wilful misconduct, or a material violation of Company policies, or you are found to be absconding from the services of the Company or for any other reasons causing grievous loss/damage/disrepute to the Company/associates, your termination will be immediate and without any notice or compensation.<br>
        c. In the event of your resignation from the services of the Company, you will be required to give the Company 1-month prior written notice. The notice period has to be served in full unless otherwise agreed by the Company in writing. In case of failure to give the above notice period, the Company shall have the right to deduct the salary in lieu of the notice period and you will not be eligible to be hired by the Company in the future. You shall, on ceasing to be an employee of the Company for any reason and in addition to the obligations under the Non-Disclosure and Confidential Information Agreement, forthwith return all Company properties, movable and immovable, including all Company information and data in any form, files, reports, memoranda, software, credit cards, door and file keys, computer access codes, laptops, desktops, and such other property which you received or in possession or prepared in connection with your employment with the Company.</li>
        <li><b>Confidential Information:</b> As an employee, you may come into possession of information confidential to the Company and agree to keep confidential, Company’s proprietary and confidential information obtained at any time during the period of your employment in the Company. Confidential information includes, and is not limited to; course materials, videos, financial documents, and other relevant documents. You shall not disclose such Confidential Information to any person. You shall not make any copies of the Confidential Information. You shall not disclose, reproduce or use any Confidential Information for any purpose except solely in connection with your performance in the company. Your obligations concerning confidentiality shall be more fully detailed under the Non-Disclosure and Confidential Information Agreement executed by you with the Company and you shall at all times be bound by the provisions laid therein</li>
        <li><b>Intellectual Property Rights:</b> All the intellectual property rights in the material developed by you, class material/Online recordings and related documents shall at all times remain the property of the Company. You shall provide all assistance and execute all deeds and documents required to vest the intellectual property rights with the Company. In the event any of the intellectual property rights are not assignable under applicable laws, you shall provide exclusive, transferable, assignable, royalty-free rights in such intellectual property in perpetuity to the Company. You shall not assert any right, title, or interest over such intellectual property rights.</li>
        <li><b>Indemnity:</b> You hereby agree to indemnify and keep indemnified and hold the Company harmless from and against any loss, claim, damage, costs, taxes, duties, additions, penalties, interest thereon or expenses of any kind, including reasonable attorney’s fees, incurred/sustained or caused to be incurred/sustained by the Company on account of:<br>
        a. Any act or mission by you;<br>
        b. Contravention of any of the terms, conditions, covenants of this letter or the  NonDisclosure and Confidential Information Agreement;<br>
        c. Any representation or warranty or information furnished to the Company found to be false;<br>
        d. Violation/non-compliance with any laws/rules/regulations while rendering the services; and/or<br>
        e. Failure to adhere to the standards/specifications/policies of the Company.</li>
        <li><b>General Regulations:</b><br>
        a. You are required to devote your entire time, attention, and effort to the furtherance of the business of the Company and to continually develop your professional skills in the interest of the Company and yourself. You shall not, during your employment with the Company, directly or indirectly engage yourself in or devote any time or attention to any part-time employment or business or position of monetary interest, other than that of the Company. Further, you shall not divulge, communicate or pass any information in any form, related to any aspect of the Company to anyone outside the Company.<br>
        b. You shall endeavour to uphold the good image of the Company and shall not by your conduct adversely affect the reputation of the Company and bring disrepute to the Company, in any manner whatsoever. You shall not conduct yourself in any manner amounting to a breach of confidence reposed in you or inconsistent with the position of responsibility occupied by you. You shall at all times deal with the Company’s money, material, and documents with utmost honesty and professional ethics.<br>
        c. Your remuneration is purely a matter between yourself and the Company and has been arrived at based on our specific background and professional merit. The Company expects that you maintain this information and any future changes to your remuneration, as strictly personal and confidential.<br>
        d. During your employment, if you, at any time render yourself incompetent to perform your duties or if you should misconduct yourself or be disobedient, intemperate, irregular in attendance, commit a breach of the terms of your employment or of any of the stipulations herein contained, the Company shall without prejudice to any of its rights under the terms herein contained, be entitled to terminate your employment forthwith without notice or payment in lieu of notice and deduct from your salary or other emoluments, if any, then due to you, including the amount of any damage that the Company may have sustained.<br>
        e. You will keep the Company informed of any change in your residential address, your family status, or any other personal particulars relevant to your employment, as and when the change occurs.<br>
        f. You are required to sign a ‘Non-Disclosure and Confidential Information Agreement’ with the Company, before joining the services of the Company. Your employment with the Company shall be contingent upon you executing the said agreement.<br>
        g. You will be subject to the Company’s rules and regulations for the time being in force and as varied from time to time.<br>
        h. The Company will deduct taxes as appropriate and consistent with applicable tax laws and regulations. You will be responsible for your tax liabilities under all applicable tax laws and regulations.<br>
        i. This letter constitutes the complete understanding between you and the Company regarding the terms of your employment with the Company. This supersedes any other agreements, either written or oral, between you and the Company regarding your employment. Any modification of this letter will be effective only if it is in writing, signed by both parties.<br>
        j. All disputes arising herein shall be governed by the laws of India and the jurisdiction to entertain and try such dispute shall vest exclusively in the courts of Ernakulam (PIN: 682017), Kerala India.
        </li>
        </ol>
        <p>The terms of your employment contract detailed above are strictly confidential and should be treated as privileged information between yourself and the Company. You are expected to maintain such information appropriately.</p>
        <p>You are requested to signify your acceptance of the terms and conditions by signing and returning to us the duplicate copy of this letter.</p>
        <p>We look forward to you joining us at the earliest. We are certain that you will find challenge, satisfaction, and opportunity in your association with the Company.</p>
        <p>You are requested to carry the below-mentioned documents on your joining date.</p>
        <ul style='text-align:left;'>
        <li>Graduation/Post Graduation–Provisional Certificate/Course Completion Certificate Copy</li>
        <li>Resume</li>
        <li>SMEC Automation Pvt. Ltd. Offer Letter</li>
        <li>Pan Card</li>
        <li>Aadhaar Card</li>
        <li>1 Passport Size Photograph</li>
        <li>All current & previous companies relieving/experience letters (Only for experienced candidates)</li>
        <li>Current/Last company’s last three months’ pay slips (Only for experienced candidates)</li>
        </ul>
        <br><br>
        <p>Yours Sincerely, Accept Job offer by signing below</p>
        <br>
        <p>For SMEC Automation Pvt Ltd</p>
        <br>
        <p>Signature</p>
        ";
        
        $pdf->writeHTML($html, true, false, true, false, '');

        // Save PDF to a file
        $filename = 'Offer_Letter_' . $emp['name'] . '_' . date('YmdHis') . '.pdf';
        $folder = WRITEPATH . 'uploads/offer_letters/';
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }
        $filepath = $folder . $filename;
        $pdf->Output($filepath, 'F');

        // Save to documents table
        $documentModel = new \App\Models\DocumentModel();
            $documentModel->insert([
                'employee_id' => $employeeId,
            'doc_type' => 'offer_letter',
                'file_name' => $filename,
            'original_name' => 'Offer_Letter.pdf',
                'uploaded_at' => date('Y-m-d H:i:s')
            ]);
        $docId = $documentModel->getInsertID();

        $offerDetailModel = new \App\Models\OfferLetterDetailModel();
        $insertId = $offerDetailModel->insert([
            'employee_id' => $employeeId,
            'joining_date' => $joiningDate,
            'salary' => $salary,
            'reporting_manager' => $reportingManager,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        if (!$insertId) {
            file_put_contents('/tmp/offer_debug.txt', "Insert failed: " . print_r($offerDetailModel->errors(), true), FILE_APPEND);
        } else {
            file_put_contents('/tmp/offer_debug.txt', "Insert success: $insertId\n", FILE_APPEND);
        }

        return $this->response->setJSON([
            'doc_id' => $docId,
            'download_url' => site_url('/admin/download/' . $docId)
        ]);
    }
} 