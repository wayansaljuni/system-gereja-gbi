<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $agreement_number
 * @property int|null $agreement_type_id
 * @property string $qty
 * @property string $title
 * @property string|null $pic
 * @property string $sifat
 * @property \Illuminate\Support\Carbon|null $start_date
 * @property \Illuminate\Support\Carbon|null $end_date
 * @property int|null $duration_value
 * @property string|null $duration_unit
 * @property bool $auto_renewal
 * @property int|null $renewal_period_value
 * @property string|null $renewal_period_unit
 * @property string $status
 * @property bool $reminder_enabled
 * @property string|null $notes
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AgreementType|null $agreementType
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Agreement> $agreements
 * @property-read int|null $agreements_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AgreementAttachment> $attachments
 * @property-read int|null $attachments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AgreementParty> $parties
 * @property-read int|null $parties_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AgreementReminder> $reminders
 * @property-read int|null $reminders_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agreement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agreement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agreement query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agreement whereAgreementNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agreement whereAgreementTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agreement whereAutoRenewal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agreement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agreement whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agreement whereDurationUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agreement whereDurationValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agreement whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agreement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agreement whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agreement wherePic($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agreement whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agreement whereReminderEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agreement whereRenewalPeriodUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agreement whereRenewalPeriodValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agreement whereSifat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agreement whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agreement whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agreement whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agreement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agreement whereUpdatedBy($value)
 */
	class Agreement extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $agreement_id
 * @property string $file_name
 * @property string $file_path
 * @property string|null $file_type
 * @property int|null $file_size
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Agreement $agreement
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementAttachment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementAttachment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementAttachment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementAttachment whereAgreementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementAttachment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementAttachment whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementAttachment whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementAttachment whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementAttachment whereFileSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementAttachment whereFileType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementAttachment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementAttachment whereUpdatedAt($value)
 */
	class AgreementAttachment extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $agreement_id
 * @property string $party_type
 * @property string $name
 * @property string|null $code
 * @property string|null $contact_person
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $tax_number
 * @property string|null $role
 * @property string|null $signatory_name
 * @property string|null $signatory_position
 * @property int $is_active
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Agreement $agreement
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementParty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementParty newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementParty query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementParty whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementParty whereAgreementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementParty whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementParty whereContactPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementParty whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementParty whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementParty whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementParty whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementParty whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementParty whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementParty wherePartyType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementParty wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementParty whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementParty whereSignatoryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementParty whereSignatoryPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementParty whereTaxNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementParty whereUpdatedAt($value)
 */
	class AgreementParty extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $agreement_id
 * @property \Illuminate\Support\Carbon $remind_at
 * @property string $title
 * @property string|null $message
 * @property bool $is_sent
 * @property \Illuminate\Support\Carbon|null $sent_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Agreement $agreement
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AgreementReminderRecipient> $recipients
 * @property-read int|null $recipients_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementReminder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementReminder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementReminder query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementReminder whereAgreementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementReminder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementReminder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementReminder whereIsSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementReminder whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementReminder whereRemindAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementReminder whereSentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementReminder whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementReminder whereUpdatedAt($value)
 */
	class AgreementReminder extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $agreement_reminder_id
 * @property int|null $user_id
 * @property string|null $name
 * @property string $email
 * @property string $recipient_type
 * @property int $is_active
 * @property bool $is_notified
 * @property \Illuminate\Support\Carbon|null $notified_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AgreementReminder $reminder
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementReminderRecipient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementReminderRecipient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementReminderRecipient query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementReminderRecipient whereAgreementReminderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementReminderRecipient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementReminderRecipient whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementReminderRecipient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementReminderRecipient whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementReminderRecipient whereIsNotified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementReminderRecipient whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementReminderRecipient whereNotifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementReminderRecipient whereRecipientType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementReminderRecipient whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementReminderRecipient whereUserId($value)
 */
	class AgreementReminderRecipient extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string|null $description
 * @property bool $has_period
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Agreement> $agreements
 * @property-read int|null $agreements_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementType whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementType whereHasPeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementType whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementType whereUpdatedAt($value)
 */
	class AgreementType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $idhpr
 * @property int $edt
 * @property string $nota
 * @property \Illuminate\Support\Carbon|null $tgl
 * @property string $nop
 * @property string $dept
 * @property string $gp
 * @property string $repacking
 * @property \App\Models\User|null $user
 * @property string $kd_cab
 * @property string $budget Y=budget T=Non Budget S=Berdasar SO B=Dropping
 * @property string $jnsbudget keterangan field budget
 * @property string $approve approve by BM ALL PR
 * @property \Illuminate\Support\Carbon|null $tglapp
 * @property string $approve1 approve by BU Leader(PR->GP>1.000.000) / SALES (PR from Sales Order)
 * @property \Illuminate\Support\Carbon|null $tglapp1
 * @property string $approve2 approve by project co cabang -> PR from SO solution
 * @property \Illuminate\Support\Carbon|null $tglapp2
 * @property string $approve3 approve by project co ho -> PR from SO solution
 * @property \Illuminate\Support\Carbon|null $tglapp3
 * @property numeric $total
 * @property string $nodo
 * @property string $nmproject
 * @property \Illuminate\Support\Carbon|null $tgldel
 * @property string $instplace
 * @property string $adress
 * @property int $map
 * @property int $layout
 * @property int $others
 * @property int $c1 std
 * @property int $c2 refrei
 * @property int $c3 import/pl
 * @property int $c4 import indent
 * @property int $c5 ss job/kitchen
 * @property int $c6 utensil
 * @property int $c7 aksesories
 * @property string $jnspack jenis packing
 * @property \Illuminate\Support\Carbon $tgl_update tgl entry /update
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $tglentry
 * @property int $updateke jumlah update
 * @property string $approveby
 * @property string $approveby1
 * @property string $inventory
 * @property int $tambahan 1=tambahan PR MI
 * @property string $kd_supp
 * @property string $jnspr 1=PR Biasa,2=PR Jasa Rekondisi ke NI
 * @property string $nik
 * @property string|null $kdlok
 * @property string $nojr NO JR
 * @property string $otorisasifa PR tanpa DP -> otorisasi ='y': approve FA lagi
 * @property string $kdseg
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereAdress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereApprove($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereApprove1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereApprove2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereApprove3($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereApproveby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereApproveby1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereBudget($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereC1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereC2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereC3($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereC4($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereC5($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereC6($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereC7($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereDept($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereEdt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereGp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereIdhpr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereInstplace($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereInventory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereJnsbudget($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereJnspack($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereJnspr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereKdCab($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereKdSupp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereKdlok($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereKdseg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereLayout($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereMap($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereNik($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereNmproject($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereNodo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereNojr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereNop($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereNota($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereOthers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereOtorisasifa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereRepacking($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereTambahan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereTgl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereTglUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereTglapp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereTglapp1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereTglapp2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereTglapp3($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereTgldel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereTglentry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereUpdateke($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hpr whereUser($value)
 */
	class Hpr extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $must_change_password
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $teams
 * @property-read int|null $teams_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, ?string $guard = null, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User team($teams, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereMustChangePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, ?string $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutTeam($teams)
 */
	class User extends \Eloquent implements \Filament\Models\Contracts\FilamentUser {}
}

