<?php

namespace App\Constants;

use App\Traits\ConstantsTrait;

enum FileConstants: string
{
    use ConstantsTrait;
    case FILE_OPPORTUNITY_PROPOSAL = 'proposal';
    case FILE_OPPORTUNITY_ATTACHMENTS = 'attachment';
    case FILE_TYPE_EMPLOYEE_AVATAR = 'employee_avatar';
    case FILE_TYPE_EMPLOYEE_COVER = 'employee_cover';
    case FILE_TYPE_EMPLOYEE_CV = 'employee_cv';
    case FILE_TYPE_EMPLOYEE_INTERVIEW_APPLICATION = 'employee_interview_application';
    case FILE_TYPE_EMPLOYEE_BIRTH_CERTIFICATE = 'employee_birth_certificate';
    case FILE_TYPE_EMPLOYEE_ID = 'employee_id';
    case FILE_TYPE_EMPLOYEE_MILITARY_CERTIFICATE = 'employee_military_certificate';
    case FILE_TYPE_EMPLOYEE_CONTRACT = 'employee_contract';
    case FILE_TYPE_EMPLOYEE_CRIMINAL_CASE_DOCUMENT = 'employee_criminal_case_document';
    case FILE_TYPE_EMPLOYEE_WORK_HEAL = 'employee_work_heal';
    case FILE_TYPE_EMPLOYEE_CLEARANCE_FORM = 'employee_clearance_form';
    case FILE_TYPE_EMPLOYEE_INSURANCE_PRINT = 'employee_insurance_print';
    case FILE_TYPE_EMPLOYEE_WORK_JOIN_FORM = 'employee_work_join_form';
    case FILE_TYPE_EMPLOYEE_APPROVAL_FORM = 'employee_approval_form';
    case FILE_TYPE_EMPLOYEE_GRADE_CERTIFICATE = 'employee_grade_certificate';
    case FILE_TYPE_EMPLOYEE_INFORMATION_FORM = 'employee_information_form';
    case FILE_TYPE_EMPLOYEE_RESIGNATION_FORM = 'employee_resignation';
    case FILE_TYPE_PROJECT_ATTACHMENTS = 'project_attachments';
    case FILE_TYPE_MILESTONE_ATTACHMENTS = 'milestone_attachments';
    case FILE_TYPE_PROJECT_SCOPE_ATTACHMENTS = 'projectScope_attachments';
    case FILE_TYPE_TASK_ATTACHMENTS = 'task_attachments';
    case FILE_TYPE_TICKET_ATTACHMENTS = 'ticket_attachments';
    case FILE_TYPE_TICKET_COMMENT_ATTACHMENTS = 'ticket_comment_attachments';
    case FILE_TYPE_NEW_PROJECT_REQUEST_ATTACHMENTS = 'new_project_request_attachments';
    case FILE_TYPE_APPLICANT_PERSONAL_AVATAR = 'applicant_personal_avatar';
    case FILE_TYPE_ARCHIVE_DOCUMENT_ATTACHMENTS = 'archive_document_attachments';
    case FILE_TYPE_PROJECT_IMAGE = 'project_image';
    case FILE_TYPE_CUSTOMER_AVATAR = 'customer_avatar';
    case FILE_TYPE_PROJECT_LINK_FILE = 'projectLink_files';
    case AWARD_TYPE_IMAGE = 'award_type_image';

    case FILE_TYPE_MEMO_ATTACH = 'memos_attach';
    case FILE_TYPE_ASSET_ITEM_ATTACH = 'asset_item_attach';



    public static function employmentAttachmentTypes(): array
    {
        return [
//            self::FILE_TYPE_EMPLOYEE_AVATAR->value => __json('pages.avatar'),
//            self::FILE_TYPE_EMPLOYEE_COVER->value => __json('pages.cover'),
            self::FILE_TYPE_EMPLOYEE_CV->value => __json('pages.cv'),
            self::FILE_TYPE_EMPLOYEE_INTERVIEW_APPLICATION->value => __json('pages.interview_application'),
            self::FILE_TYPE_EMPLOYEE_BIRTH_CERTIFICATE->value => __json('pages.birth_certificate'),
            self::FILE_TYPE_EMPLOYEE_ID->value => __json('pages.civil_id'),
            self::FILE_TYPE_EMPLOYEE_MILITARY_CERTIFICATE->value => __json('pages.military_certificate'),
            self::FILE_TYPE_EMPLOYEE_CONTRACT->value => __json('pages.contract'),
            self::FILE_TYPE_EMPLOYEE_CRIMINAL_CASE_DOCUMENT->value => __json('pages.criminal_case_document'),
            self::FILE_TYPE_EMPLOYEE_WORK_HEAL->value => __json('pages.work_heal'),
            self::FILE_TYPE_EMPLOYEE_CLEARANCE_FORM->value => __json('pages.clearance_form'),
            self::FILE_TYPE_EMPLOYEE_INSURANCE_PRINT->value => __json('pages.insurance_print'),
            self::FILE_TYPE_EMPLOYEE_WORK_JOIN_FORM->value => __json('pages.work_join_form'),
            self::FILE_TYPE_EMPLOYEE_APPROVAL_FORM->value => __json('pages.approval_form'),
            self::FILE_TYPE_EMPLOYEE_GRADE_CERTIFICATE->value => __json('pages.grade_certificate'),
            self::FILE_TYPE_EMPLOYEE_INFORMATION_FORM->value => __json('pages.information_form'),
            self::FILE_TYPE_EMPLOYEE_RESIGNATION_FORM->value => __json('pages.resignation_form'),
        ];
    }

    public static function fileableTypes(): array
    {
        return [
            'Task',
            'Ticket',
            'Opportunity'
        ];
    }

    public static function applicantAttachmentTypes(): array
    {
       return array_merge(self::employmentAttachmentTypes(), [

            self::FILE_TYPE_APPLICANT_PERSONAL_AVATAR->value => __json('pages.applicant_personal_avatar')
       ]);
    }

    public function label(){
        return self::employmentAttachmentTypes()[$this->value]??'';
    }

}
