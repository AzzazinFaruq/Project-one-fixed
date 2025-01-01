package models

import "time"

type Keluarga struct {
	Id         int64     `gorm:"primaryKey" json:"id"`
	NoKk       int64     `json:"no_kk"`
	KkNik      int64     `json:"kk_nik"`
	KkNama     string    `json:"kk_nama"`
	Alamat     string    `json:"alamat"`
	Rt         string    `json:"rt"`
	Rw         string    `json:"rw"`
	KodePos    string    `json:"kode_pos"`
	Status     int8      `json:"status"`
	UserId     int64     `json:"user_id"`
	FotoKk     string    `json:"foto_kk"`
	FotoRumah  string    `json:"foto_rumah"`
	Latitude   float64   `json:"latitude"`
	Longtitude float64   `json:"longtitude"`
	CreatedAt  time.Time `gorm:"type:timestamp;default:current_timestamp" json:"created_at"`
	UpdatedAt  time.Time `gorm:"type:timestamp;default:current_timestamp on update current_timestamp" json:"updated_at"`
	User       User      `gorm:"foreignKey:UserId;references:Id;	constraint:OnUpdate:CASCADE,OnDelete:SET NULL;"`
}
