package models

import "time"

type Penduduk struct {
	Id         int64     `gorm:"primaryKey"`
	KelsId     int64     `json:"kels_id"`
	Nik        int64     `json:"nik"`
	Nama       string    `json:"nama"`
	TmpLahir   string    `json:"tmp_lahir"`
	TglLahir   time.Time `json:"tgl_lahir"`
	Kelamin    int8      `json:"kelamin"`
	StatKawin  int8      `json:"stat_kawin"`
	HubKel     int8      `json:"hub_kel"`
	WargaNeg   int8      `json:"warga_neg"`
	Agama      int8      `json:"agama"`
	Pendidikan int8      `json:"pendidikan"`
	Pekerjaan  int8      `json:"pekerjaan"`
	Ayah       string    `json:"ayah"`
	Ibu        string    `json:"ibu"`
	KepalaKel  string    `json:"kepala_kel"`
	NoHp       string    `json:"no_hp"`
	Domisili   int8      `json:"domisili"`
	Status     int8      `json:"status"`
	UserId     int64     `json:"user_id"`
	CreatedAt  time.Time `gorm:"type:timestamp;default:current_timestamp"`
	UpdatedAt  time.Time `gorm:"type:timestamp;default:current_timestamp on update current_timestamp"`
	User       User      `gorm:"foreignKey:UserId;references:Id;constraint:OnUpdate:CASCADE,OnDelete:SET NULL;"`
	Keluarga   Keluarga  `gorm:"foreignKey:KelsId;references:Id;constraint:OnUpdate:CASCADE,OnDelete:SET NULL;"`
}
