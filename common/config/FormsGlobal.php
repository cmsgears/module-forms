<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\forms\common\config;

class FormsGlobal {

	// System Sites ---------------------------------------------------

	// System Pages ---------------------------------------------------

	// Grouping by type ------------------------------------------------

	const TYPE_FORM_SUBMIT			= 'form-submit';
	const TYPE_FORM_SUBMIT_FIELD	= 'form-submit-field';

	// Templates -------------------------------------------------------

	const TEMPLATE_FORM	= 'form';

	const TEMPLATE_NOTIFY_FORM_SUBMIT   = 'form-submit';

	// Config ----------------------------------------------------------

	// Roles -----------------------------------------------------------

	// Permissions -----------------------------------------------------

	const PERM_FORM_ADMIN		= 'admin-forms';

	const PERM_FORM_MANAGE		= 'manage-forms';
	const PERM_FORM_AUTHOR		= 'form-author';

	const PERM_FORM_VIEW		= 'view-forms';
	const PERM_FORM_ADD			= 'add-form';
	const PERM_FORM_UPDATE		= 'update-form';
	const PERM_FORM_DELETE		= 'delete-form';
	const PERM_FORM_APPROVE		= 'approve-form';
	const PERM_FORM_PRINT		= 'print-form';
	const PERM_FORM_IMPORT		= 'import-forms';
	const PERM_FORM_EXPORT		= 'export-forms';

	// Model Attributes ------------------------------------------------

	// Default Maps ----------------------------------------------------

	// Messages --------------------------------------------------------

	// Errors ----------------------------------------------------------

	const ERROR_RE_SUBMIT		= 'reSubmitFormError';

	// Model Fields ----------------------------------------------------

	// Generic Fields

	// Field
	const FIELD_SUBMITTED_BY	= 'submittedByField';

}
